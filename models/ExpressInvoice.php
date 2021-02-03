<?php

namespace panix\mod\novaposhta\models;

use panix\engine\CMS;
use Yii;
use panix\mod\cart\models\Order;
use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\query\CommonQuery;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "novaposhta_express_invoice".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class ExpressInvoice extends ActiveRecord
{

    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';
    public $order;
    public $products;
    public $inValidProduct;
    public $recipient_FirstName;
    public $recipient_MiddleName;
    public $recipient_LastName;
    //public $recipient_Phone;
    public $recipient_City;
    public $recipient_Region;
    public $recipient_Email;

    //public $recipient_Warehouse;

    public static function find()
    {
        return new CommonQuery(get_called_class());
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__express_invoice}}';
    }

    public function init()
    {

        $config = Yii::$app->settings->get('novaposhta');
        if ($config->serviceType) {
            $this->ServiceType = $config->serviceType;
            $this->CitySender = $config->sender_city;
            $this->SenderAddress = $config->sender_warehouse;
            $this->SendersPhone = $config->sender_phone;
            $this->SeatsAmount = $config->seatsAmount;
        }

        $this->DateTime = date('d.m.Y');
        $senderData = Yii::$app->novaposhta->getCounterparties('Sender', 1, '', '');
        if ($senderData['success']) {
            $contact = Yii::$app->novaposhta->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
            //\panix\engine\CMS::dump($contact);
            if ($contact['success']) {
                //  $this->SendersPhone = $contact['data'][0]['Phones'];
                $this->Sender = $senderData['data'][0]['Ref'];
            }
        }
        if (Yii::$app->request->get('order_id')) {
            $this->order = Order::findModel(Yii::$app->request->get('order_id'));
            if ($this->order->user_phone)
                $this->RecipientsPhone = $this->order->user_phone;
            if ($this->order->delivery_warehouse_ref) {
                $this->RecipientAddress = Warehouses::findOne(['Ref' => $this->order->delivery_warehouse_ref]);
            }

            if ($this->order->delivery_city_ref) {
                $site = Cities::findOne(['Ref' => $this->order->delivery_city_ref]);
                if ($site) {
                    $this->CityRecipient = $site->Description;
                }
            }


            foreach ($this->order->products as $product) {
                $original = $product->originalProduct;
                if (!$original->width || !$original->height || !$original->length) {
                    $this->products['volumeGeneral'][] = $product;
                } else {
                    $this->VolumeGeneral += $original->width + $original->height + $original->length;
                }
                if (!$original->weight) {
                    $this->products['weight'][] = $product;
                } else {
                    $this->Weight += $original->weight;
                }
            }

            $this->Cost = $this->order->total_price;
            $this->recipient_FirstName = $this->order->user_name;
            $this->recipient_LastName = $this->order->user_lastname;
            $this->recipient_Email = $this->order->user_email;
            //$this->recipient_City = Cities::findOne(['Ref' => $this->order->delivery_city_ref]);
            $this->recipient_City = $this->order->delivery_city_ref;

            $this->CargoType = 'Cargo';
            if ($this->order->products) {
                $list = [];
                foreach ($this->order->products as $product) {
                    $list[] = $product->name . ', ' . $product->quantity . ' шт.';
                }
                $this->Description = mb_strcut(implode(', ', $list), 0, 50);


            }
        }


        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ //'pattern' => '/^[a-zA-Z0-9-_]\w*$/i',
            [['recipient_FirstName', 'recipient_LastName'], 'match', 'pattern' => '/^([а-яА-Я]+)$/u', 'message' => '{attribute} должен содержать только буквы кириллицы.'],
            // [['Description'], 'match', 'pattern' => '/^([а-яА-Я0-9\w+]+)$/u','message'=>'{attribute} должен содержать только буквы кириллицы.'],
            [[
                'PayerType',
                'PaymentMethod',
                'DateTime',
                'CargoType',
                'VolumeGeneral',
                'Weight',
                'ServiceType',
                'SeatsAmount',
                'Description',
                'Cost',
                'CitySender',
                'Sender',
                'SenderAddress',
                'ContactSender',
                'SendersPhone',
                // 'CityRecipient',
                // 'Recipient',
                'RecipientAddress',
                // 'ContactRecipient',
                'RecipientsPhone'
            ], 'required'],


            //получаель
            [[
                'recipient_FirstName',
                // 'recipient_MiddleName',
                'recipient_LastName',
                //'recipient_Phone',
                'recipient_City',
                //'recipient_Region',
                //'recipient_Email',
                'RecipientAddress'
            ], 'required'],

            [['recipient_Email'], 'email'],
            [['Description'], 'string', 'max' => 50],
            //[['ref'], 'string'],
            //[['ref'], 'trim'],
        ];
    }


    public function paymentFormsList()
    {
        $list = Yii::$app->novaposhta->getPaymentForms();
        $result = [];
        if ($list['success']) {
            foreach ($list['data'] as $item) {
                $result[$item['Ref']] = $item['Description'];
            }
        }
        return $result;
    }

    protected $_invoice;

    public function cargoTypes()
    {
        $list = Yii::$app->novaposhta->getCargoTypes();
        $result = [];
        if ($list['success']) {
            foreach ($list['data'] as $item) {
                $result[$item['Ref']] = $item['Description'];
            }
        }
        return $result;
    }


    public function create()
    {
        /**
         * @var $api Novaposhta
         */
        $api = Yii::$app->novaposhta;
        $senderInfo = $api->getCounterparties('Sender', 1, '', '');

        $sender = $senderInfo['data'][0];

// Информация о складе отправителя

        $city = $api->getCity('Киев', 'Киевская');
//CMS::dump($city['data'][0]['Ref']);die;

        $senderWarehouses = $api->getWarehouses($city['data'][0]['Ref']);


        $contact = $api->getCounterpartyContactPersons($senderInfo['data'][0]['Ref']);
        $address = $api->getCounterpartyAddresses($senderInfo['data'][0]['Ref']);

//CMS::dump($senderInfo);die;
        // print_r($this);die;
        $result = $api->newInternetDocument(
        // Данные отправителя
            [
                // Данные пользователя
                'FirstName' => $sender['FirstName'],
                'MiddleName' => $sender['MiddleName'],
                'LastName' => $sender['LastName'],
                // Вместо FirstName, MiddleName, LastName можно ввести зарегистрированные ФИО отправителя или название фирмы для юрлиц
                // (можно получить, вызвав метод getCounterparties('Sender', 1, '', ''))
                //'Description' => $sender['Description'],
                // Необязательное поле, в случае отсутствия будет использоваться из данных контакта
                // 'Phone' => $contact['data'][0]['Phones'],
                // Город отправления
                // 'City' => 'Белгород-Днестровский',
                // Область отправления
                // 'Region' => 'Одесская',
                'CitySender' => $this->CitySender,//$city['data'][0]['Ref'],
                // Отделение отправления по ID (в данном случае - в первом попавшемся)
                'SenderAddress' => $this->SenderAddress,//$senderWarehouses['data'][0]['Ref'],
                // Отделение отправления по адресу
                // 'Warehouse' => $senderWarehouses['data'][0]['DescriptionRu'],
            ],
            // Данные получателя
            [


                'FirstName' => $this->recipient_FirstName,
                'MiddleName' => ($this->recipient_MiddleName) ? $this->recipient_MiddleName : '',
                'LastName' => $this->recipient_LastName,
                'Phone' => $this->RecipientsPhone,
                'City' => $this->recipient_City,
                'Region' => ($this->recipient_Region) ? $this->recipient_Region : '',
                'Email' => ($this->recipient_Email) ? $this->recipient_Email : '',
                'Warehouse' => $this->RecipientAddress,
            ],
            [
                // Дата отправления
                'DateTime' => $this->DateTime,
                // Тип доставки, дополнительно - getServiceTypes()
                'ServiceType' => $this->ServiceType,
                // Тип оплаты, дополнительно - getPaymentForms()
                'PaymentMethod' => 'Cash',
                // Кто оплачивает за доставку
                'PayerType' => 'Recipient',
                // Стоимость груза в грн
                'Cost' => $this->Cost,
                // Кол-во мест
                'SeatsAmount' => $this->SeatsAmount,
                // Описание груза
                'Description' => $this->Description,
                // Тип доставки, дополнительно - getCargoTypes
                'CargoType' => 'Cargo',
                // Вес груза
                'Weight' => $this->Weight,
                // Объем груза в куб.м.
                'VolumeGeneral' => $this->VolumeGeneral,


//Параметр груза для каждого места отправления
                /*"OptionsSeat" => [
                    [
                        "weight" => 5,
                        "volumetricHeight" => 50,
                        "volumetricWidth" => 10,
                        "volumetricLength" => 10,
                        "cost" => "1",
                        "description" => "1",
                        "specialCargo" => "1"
                    ],
                    [
                        "weight" => 7,
                        "volumetricHeight" => 50,
                        "volumetricWidth" => 10,
                        "volumetricLength" => 10,
                        "cost" => "1",
                        "description" => "1",
                        "specialCargo" => "1"
                    ]
                ],*/


                // Обратная доставка
                'BackwardDeliveryData' => [
                    [
                        // Кто оплачивает обратную доставку
                        'PayerType' => 'Recipient',
                        // Тип доставки
                        'CargoType' => 'Money',
                        // Значение обратной доставки
                        'RedeliveryString' => $this->Cost,
                    ]
                ]
            ]
        );

        //  CMS::dump($this->attributes);die;
        /*if ($result['success']) {
            foreach ($result['warnings'] as $warning) {
                Yii::$app->session->setFlash('warning', $warning);
            }
            $this->_invoice = $result['data'];

            return $result['data'];
        } else {

        }*/
        return $result;
    }

    public function getOrderItem()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function beforeDelete()
    {
        $delete = Yii::$app->novaposhta->model('InternetDocument')->delete(['DocumentRefs' => $this->Ref]);

        if ($delete['success']) {
            return parent::beforeDelete();
        }
        return false;
    }

    public function attributeLabels()
    {
        return array_merge([
            'recipient_City' => self::t('RECIPIENT_CITY'),
            'recipient_LastName' => self::t('RECIPIENT_LASTNAME'),
            'recipient_FirstName' => self::t('RECIPIENT_FIRSTNAME'),
            'recipient_MiddleName' => self::t('RECIPIENT_MIDDLENAME'),
            'recipient_Email' => self::t('RECIPIENT_EMAIL'),
            'recipient_Region' => self::t('RECIPIENT_REGION')

        ], parent::attributeLabels());
    }

}
