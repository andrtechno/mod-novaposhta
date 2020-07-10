<?php

namespace panix\mod\novaposhta\models;

use panix\engine\base\Model;
use panix\engine\CMS;
use panix\mod\cart\models\Order;
use Yii;

/**
 * Class ExpressInvoiceForm
 * @package panix\mod\novaposhta\models
 */
class ExpressInvoiceForm extends Model
{

    protected $module = 'novaposhta';
    public static $category = 'novaposhta';

    public $PayerType;
    public $PaymentMethod;
    public $DateTime;
    public $CargoType;
    public $VolumeGeneral;
    public $Weight;
    public $ServiceType;
    public $SeatsAmount;
    public $Description;
    public $Cost;
    public $CitySender;
    public $Sender;
    public $SenderAddress;
    public $ContactSender;
    public $SendersPhone;
    public $CityRecipient;
    public $Recipient;
    public $RecipientAddress;
    public $ContactRecipient;
    public $RecipientsPhone;

    public $recipient_FirstName;
    public $recipient_MiddleName;
    public $recipient_LastName;
    public $recipient_Phone;
    public $recipient_City;
    public $recipient_Region;
    public $recipient_Email;
    public $recipient_Warehouse;

    protected $order;
    public function init()
    {

        $config = Yii::$app->settings->get('novaposhta');
        if ($config->serviceType) {
            $this->ServiceType = $config->serviceType;
        }
        if (Yii::$app->request->get('order_id')) {
            $this->order = Order::findModel(Yii::$app->request->get('order_id'));
            if ($this->order->user_phone)
                $this->recipient_Phone = $this->order->user_phone;
            if ($this->order->user_address)
                $this->order->recipient_Warehouse = $this->order->user_address;

            $this->Cost = $this->order->total_price;
            $this->recipient_FirstName = $this->order->user_name;
            $this->recipient_Email = $this->order->user_email;
            $this->CargoType = 'Cargo';
            if($this->order->products){
                foreach ($this->order->products as $product){
                    $this->Description .= $product->name.', '.$product->quantity.' шт.';
                }
            }
        }
        parent::init();
    }

    public function save()
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
                'FirstName' => 'Вася',
                'MiddleName' => '',
                'LastName' => 'Тестер',
                'Phone' => '380682937379',
                'City' => 'Киев',
                'Region' => 'Киевская',
                'Email' => 'andrew.panix@gmail.com',
                'Warehouse' => 'Отделение №3: ул. Калачевская, 13 (Старая Дарница)',
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
                'SeatsAmount' => '1',
                // Описание груза
                'Description' => $this->Description,
                // Тип доставки, дополнительно - getCargoTypes
                'CargoType' => 'Cargo',
                // Вес груза
                'Weight' => $this->Weight,
                // Объем груза в куб.м.
                'VolumeGeneral' => '0.5',
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

    }

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
                //'CitySender',
                //'Sender',
                //'SenderAddress',
                //'ContactSender',
                //'SendersPhone',
                //'CityRecipient',
                //'Recipient',
                //'RecipientAddress',
                //'ContactRecipient',
                //'RecipientsPhone'
            ], 'required'],


            /*[[
                'sender_FirstName',
                'sender_MiddleName',
                'sender_LastName',
                'sender_Phone',
                'sender_City',
                'sender_Region',
                'sender_Email',
                'sender_Warehouse'
            ], 'required'],*/
            /*[[
                'CitySender',
                'SenderAddress',
                'ContactSender',
                'SendersPhone'
            ], 'required'],*/

            //получаель
            [[
                'recipient_FirstName',
                'recipient_MiddleName',
                'recipient_LastName',
                'recipient_Phone',
                'recipient_City',
                'recipient_Region',
                'recipient_Email',
                'recipient_Warehouse'
            ], 'required'],

            //[['ref'], 'string', 'max' => 32],
            //[['ref'], 'string'],
            //[['ref'], 'trim'],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'api_key' => '',
        ];
    }

    public function serviceTypesList()
    {
        $list = Yii::$app->novaposhta->getServiceTypes();
        $result = [];
        if ($list['success']) {
            foreach ($list['data'] as $item) {
                $result[$item['Ref']] = $item['Description'];
            }
        }
        return $result;
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
}