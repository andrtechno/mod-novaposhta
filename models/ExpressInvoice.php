<?php

namespace panix\mod\novaposhta\models;

use panix\engine\CMS;
use Yii;
use panix\mod\cart\models\Order;
use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\query\CommonQuery;
use panix\engine\db\ActiveRecord;
use yii\helpers\Html;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "novaposhta_express_invoice".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $orderItem
 */
class ExpressInvoice extends ActiveRecord
{
    public $_errors;
    public $_warnings;
    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';
    public $order;

    public $products;
    public $inValidProduct;
    public $recipient_FirstName;
    public $recipient_MiddleName;
    public $recipient_LastName;
    //public $recipient_Phone;
    // public $CityRecipient;
    public $recipient_Region;
    public $recipient_Email;
    // public $OptionsSeat;
    // public $BackwardDeliveryData;

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
            $this->ServiceTypeRef = $config->serviceType;
            $this->CitySenderRef = $config->sender_city;
            $this->SenderAddressRef = $config->sender_warehouse;
            $this->SendersPhone = $config->sender_phone;
            $this->SeatsAmount = $config->seatsAmount;
        }


        $date = new \DateTime('now', new \DateTimeZone('Europe/Kiev'));
        $this->DateTime = $date->format('d.m.Y');

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
                //$this->RecipientAddress = Warehouses::findOne(['Ref' => $this->order->delivery_warehouse_ref]);
                $this->RecipientAddressRef = $this->order->delivery_warehouse_ref;
            }

            if ($this->order->delivery_city_ref) {
                $site = Cities::findOne(['Ref' => $this->order->delivery_city_ref]);
                if ($site) {
                    $this->CityRecipientRef = $site->Description;
                }
                $this->CityRecipientRef = $this->order->delivery_city_ref;
            }


            foreach ($this->order->products as $product) {
                $original = $product->originalProduct;
                if (!$original->width || !$original->height || !$original->length) {
                    $this->products['volumeGeneral'][] = $product;
                } else {
                    $this->VolumeGeneral += $original->width + $original->height + $original->length / 4000;
                }
                if (!$original->weight) {
                    $this->products['weight'][] = $product;
                } else {
                    $this->Weight += $original->weight;
                }
            }

            $this->Cost = $this->order->full_price;
            $this->recipient_FirstName = $this->order->user_name;
            $this->recipient_LastName = $this->order->user_lastname;
            $this->recipient_Email = $this->order->user_email;
            //$this->recipient_City = Cities::findOne(['Ref' => $this->order->delivery_city_ref]);
            // $this->CityRecipient = $this->order->delivery_city_ref;

            $this->CargoType = 'Parcel';
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

    public function validateOptionsSeatRequire($attribute)
    {
        $validator = new RequiredValidator();
        if (isset($this->{$attribute})) {
            foreach ($this->{$attribute} as $index => $row) {
                $error = null;
                foreach (array_keys($row) as $name) {
                    $error = null;
                    $value = isset($row[$name]) ? $row[$name] : null;
                    $validator->validate($value, $error);
                    if (!empty($error)) {
                        $key = $attribute . '[' . $index . '][' . $name . ']';
                        $this->addError($key, $error);
                    }
                }
            }
        }
    }

    public function validateOptionsSeatNumber($attribute)
    {
        $validator = new NumberValidator();
        $validator->integerOnly = false;
        if (isset($this->{$attribute})) {
            foreach ($this->{$attribute} as $index => $row) {
                $error = null;
                foreach (array_keys($row) as $name) {
                    $value = isset($row[$name]) ? $row[$name] : null;
                    $error = null;

                    $validator->validate($value, $error);
                    if (!empty($error)) {
                        $key = $attribute . '[' . $index . '][' . $name . ']';
                        $this->addError($key, $error);
                    }
                }
            }
        }
    }
    public function getCalcCubeFormula($width,$height,$length)
    {
        return ($width * $height * $length) / 4000;

    }
    public function getCalcCube()
    {
        $result = 0;
        foreach ($this->OptionsSeat as $index => $row) {
            $result += ($row['volumetricWidth'] * $row['volumetricHeight'] * $row['volumetricLength']) / 4000;
        }
        return $result;
    }

    public function getCalcTotalWeight()
    {
        $result = 0;
        foreach ($this->OptionsSeat as $index => $row) {
            $result += $row['weight'];
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['OptionsSeat', 'validateOptionsSeatRequire', 'skipOnEmpty' => false],
            ['OptionsSeat', 'validateOptionsSeatNumber'],
            //['BackwardDeliveryData', 'validateOptionsSeatNumber'],


            //'pattern' => '/^[a-zA-Z0-9-_]\w*$/i',
            [['recipient_FirstName', 'recipient_LastName'], 'match', 'pattern' => '/^([а-яА-Я]+)$/u', 'message' => '{attribute} должен содержать только буквы кириллицы.'],
            // [['Description'], 'match', 'pattern' => '/^([а-яА-Я0-9\w+]+)$/u','message'=>'{attribute} должен содержать только буквы кириллицы.'],
            [[
                'PayerType',
                'PaymentMethod',
                'DateTime',
                'CargoType',
                // 'VolumeGeneral',
                // 'Weight',
                'ServiceTypeRef',
                // 'SeatsAmount',
                'Description',
                'Cost',
                'CitySenderRef',
                'Sender',
                'SenderAddressRef',
                'ContactSender',
                'SendersPhone',
                // 'CityRecipient',
                // 'Recipient',
                // 'ContactRecipient',
                'RecipientsPhone'
            ], 'required'],
           // [['RecipientsPhone','SendersPhone'], 'panix\ext\telinput\PhoneInputValidator'],

            //получаель
            [[
                //'recipient_Phone',
                'CityRecipientRef',
                //'recipient_Region',
                //'recipient_Email',
                'RecipientAddressRef'
            ], 'required'],


            [['recipient_FirstName', 'recipient_LastName',], 'required', 'on' => 'create'],


            [['recipient_Email'], 'email'],
            [['Description'], 'string', 'max' => 50],
            [['BackwardDeliveryData'], 'safe'],
            [['order_id', 'IntDocNumber'], 'integer'],

            //[['OptionsSeat', 'BackwardDeliveryData'], 'string'],
            //[['ref'], 'trim'],
        ];
    }

    public function scenarios()
    {
        $scenarios['create'] = ['recipient_FirstName', 'recipient_LastName', 'CitySenderRef', 'SenderAddressRef'];
        $scenarios['update'] = [
            'RecipientsPhone',
            'OptionsSeat',
            'BackwardDeliveryData',
            'RecipientAddressRef',
            'CityRecipientRef',
            'Description',
            'CitySenderRef',
            'SenderAddressRef',
            'ServiceTypeRef',
            'DateTime',
            'CargoType',
            'PaymentMethod',
            'PayerType',
            'Cost'
        ];
        return array_merge($scenarios, parent::scenarios());
    }

    /* private $old_ie;
*/
    public function beforeSave($insert)
    {
        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;
        $this->Weight = $this->getCalcTotalWeight();
        // Объем груза в куб.м.
        $this->VolumeGeneral = $this->getCalcCube();
        $this->SeatsAmount = count($this->OptionsSeat);

        if ($insert) {

            $response = $this->create();
            if ($response['success']) {
              //  CMS::dump($response['data']);die;
                $this->Ref = $response['data'][0]['Ref'];
            }

            //CMS::dump($this->attributes);die;
            // $this->old_ie = ExpressInvoice::find()->where(['order_id' => $this->order_id])->all();
        } else {
            $params = [];

            $params['Ref'] = $this->Ref;
            $params['Description'] = $this->Description;
            $params['PayerType'] = $this->PayerType;
            $params['PaymentMethod'] = $this->PaymentMethod;
            $params['DateTime'] = $this->DateTime;
            $params['CargoType'] = $this->CargoType;
            $params['ServiceType'] = $this->ServiceTypeRef;
            $params['Cost'] = $this->Cost;
            $params['CitySender'] = $this->CitySenderRef;
            $params['Sender'] = $this->Sender;
            $params['SenderAddress'] = $this->SenderAddressRef;
            $params['ContactSender'] = $this->ContactSender;
            $params['SendersPhone'] = $this->SendersPhone;
            $params['CityRecipient'] = $this->CityRecipientRef;
            $params['Recipient'] = $this->RecipientRef;
            $params['RecipientAddress'] = $this->RecipientAddressRef;
            $params['ContactRecipient'] = $this->ContactRecipientRef;
            $params['RecipientsPhone'] = $this->RecipientsPhone;
            $params['SeatsAmount'] = count($this->OptionsSeat);
            $params['Weight'] = $this->getCalcTotalWeight();
            //$params['VolumeWeight'] = $this->getCalcTotalWeight();
            // Объем груза в куб.м.
            $params['VolumeGeneral'] = $this->getCalcCube();
            if ($this->OptionsSeat) {
                $params['OptionsSeat'] = $this->OptionsSeat;

            }
           // CMS::dump($this->BackwardDeliveryData);die;
            if ($this->BackwardDeliveryData)
                $params['BackwardDeliveryData'] = $this->BackwardDeliveryData;
         //  CMS::dump($params);die;
            $response = $api->model('InternetDocument')->update($params);


        }

        if ($response['success']) {


            $data = $api->getDocument($this->Ref);
          //  CMS::dump($data);die;
            if ($data['success']) {
                //  CMS::dump($data);die;
                $this->ContactRecipient = $data['data'][0]['ContactRecipient'];
                $this->ContactRecipientRef = $data['data'][0]['ContactRecipientRef'];

                $this->CityRecipient = $data['data'][0]['CityRecipient'];
                $this->RecipientAddress = $data['data'][0]['RecipientAddress'];


                $this->CitySender = $data['data'][0]['CitySender'];
                $this->SenderAddress = $data['data'][0]['SenderAddress'];

                $this->RecipientRef = $data['data'][0]['RecipientRef'];

                $this->ServiceType = $data['data'][0]['ServiceType'];

                $this->CostOnSite = $data['data'][0]['CostOnSite'];
            }else{
                foreach ($data['errors'] as $key => $error) {
                    $this->_errors[] = $data['errorCodes'][$key] . ' - ' . $error;
                }
            }



            $this->IntDocNumber = $response['data'][0]['IntDocNumber'];

            if ($this->order_id) {
                $order = Order::findOne($this->order_id);
                if ($order) {

                    $order->ttn = $this->IntDocNumber;
                    $order->delivery_price = $this->CostOnSite;
                    $order->save(false);
                }
            }
            if (isset($response['warnings'])) {
                foreach ($response['warnings'] as $warn) {
                    $this->_warnings[] = $warn;
                }
            }
        } else {

            foreach ($response['errors'] as $key => $error) {
                $this->_errors[] = $response['errorCodes'][$key] . ' - ' . $error;
            }

            return false;
        }
        $this->BackwardDeliveryData = json_encode($this->BackwardDeliveryData);
        $this->OptionsSeat = json_encode($this->OptionsSeat);
        //CMS::dump($this->attributes);die;
        return parent::beforeSave($insert);
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
        //first Cash!
        arsort($result);
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
        // print_r($this->DateTime);die;


       // $this->Weight = $this->getCalcTotalWeight();
        // Объем груза в куб.м.
       // $this->VolumeGeneral = $this->getCalcCube();
        //$this->SeatsAmount = count($this->OptionsSeat);
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
                'CitySender' => $this->CitySenderRef,//$city['data'][0]['Ref'],
                // Отделение отправления по ID (в данном случае - в первом попавшемся)
                'SenderAddress' => $this->SenderAddressRef,//$senderWarehouses['data'][0]['Ref'],
                // Отделение отправления по адресу
                // 'Warehouse' => $senderWarehouses['data'][0]['DescriptionRu'],
            ],
            // Данные получателя
            [


                'FirstName' => $this->recipient_FirstName,
                'MiddleName' => ($this->recipient_MiddleName) ? $this->recipient_MiddleName : '',
                'LastName' => $this->recipient_LastName,
                'Phone' => $this->RecipientsPhone,
                'City' => $this->CityRecipientRef,
                'Region' => ($this->recipient_Region) ? $this->recipient_Region : '',
                'Email' => ($this->recipient_Email) ? $this->recipient_Email : '',
                //'Warehouse' => $this->RecipientAddress,
                'CityRecipient' => $this->CityRecipientRef,
                'RecipientAddress' => $this->RecipientAddressRef
            ],
            [
                // Дата отправления
                'DateTime' => $this->DateTime,
                // Тип доставки, дополнительно - getServiceTypes()
                'ServiceType' => $this->ServiceTypeRef,
                // Тип оплаты, дополнительно - getPaymentForms()
                'PaymentMethod' => $this->PaymentMethod,
                // Кто оплачивает за доставку
                'PayerType' => $this->PayerType,
                // Стоимость груза в грн
                'Cost' => $this->Cost,
                // Кол-во мест
                'SeatsAmount' => $this->SeatsAmount,
                // Описание груза
                'Description' => $this->Description,
                // Тип доставки, дополнительно - getCargoTypes
                'CargoType' => $this->CargoType,
                // Вес груза
                'Weight' => $this->Weight,
                'VolumeWeight' => $this->Weight,
                // Объем груза в куб.м.
                'VolumeGeneral' => $this->VolumeGeneral,


                //Параметр груза для каждого места отправления
                'OptionsSeat' => $this->OptionsSeat,
                // Обратная доставка
                'BackwardDeliveryData' => $this->BackwardDeliveryData,

            ]
        );

        //  CMS::dump($this->attributes);die;




        return $result;
    }

    public function getOrderItem()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
public function afterFind()
{
    $this->BackwardDeliveryData = json_decode($this->BackwardDeliveryData,true);
    $this->OptionsSeat = json_decode($this->OptionsSeat,true);
    parent::afterFind();
}

    public function afterDelete()
    {
        $delete = Yii::$app->novaposhta->model('InternetDocument')->delete(['DocumentRefs' => $this->Ref]);


        parent::afterDelete();


    }

    public function attributeLabels()
    {
        return array_merge([
            'CityRecipientRef' => self::t('RECIPIENT_CITY'),
            'recipient_LastName' => self::t('RECIPIENT_LASTNAME'),
            'recipient_FirstName' => self::t('RECIPIENT_FIRSTNAME'),
            'recipient_MiddleName' => self::t('RECIPIENT_MIDDLENAME'),
            'recipient_Email' => self::t('RECIPIENT_EMAIL'),
            'recipient_Region' => self::t('RECIPIENT_REGION')

        ], parent::attributeLabels());
    }

}
