<?php

namespace panix\mod\novaposhta\models;

use panix\mod\cart\models\Order;
use panix\mod\novaposhta\models\query\CitiesQuery;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "novaposhta".
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
        return new CitiesQuery(get_called_class());
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta_express_invoice}}';
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
            if ($this->order->user_address)
                $this->RecipientAddress = $this->order->user_address;

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
            $this->recipient_Email = $this->order->user_email;
            $this->CargoType = 'Cargo';
            if ($this->order->products) {
                $list = [];
                foreach ($this->order->products as $product) {
                    $list[] = $product->name . ', ' . $product->quantity . ' шт.';
                }
                $this->Description = implode(', ', $list);

            }
        }


        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
                // 'recipient_Warehouse'
            ], 'required'],

            [['recipient_Email'], 'email'],
            //[['ref'], 'string', 'max' => 32],
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

    public function beforeSave($insert)
    {


        $api = Yii::$app->novaposhta;
        $senderInfo = $api->getCounterparties('Sender', 1, '', '');
        //  CMS::dump($senderInfo);
        $sender = $senderInfo['data'][0];
// Информация о складе отправителя

        $city = $api->getCity('Киев', 'Киевская');
//CMS::dump($city['data'][0]['Ref']);die;

        $senderWarehouses = $api->getWarehouses($city['data'][0]['Ref']);


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
                // 'Description' => $sender['Description'],
                // Необязательное поле, в случае отсутствия будет использоваться из данных контакта
                'Phone' => '0682937379',
                // Город отправления
                // 'City' => 'Белгород-Днестровский',
                // Область отправления
                // 'Region' => 'Одесская',
                'CitySender' => $city['data'][0]['Ref'],
                // Отделение отправления по ID (в данном случае - в первом попавшемся)
                'SenderAddress' => $senderWarehouses['data'][0]['Ref'],
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
        if ($result['success']) {
            return $result['data'];
        } else {
            return $result;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave2($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

    }
}
