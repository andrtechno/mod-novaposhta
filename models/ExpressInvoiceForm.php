<?php

namespace panix\mod\novaposhta\models;

use panix\engine\base\Model;
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

    public function rules()
    {
        return [
            [['PayerType', 'PaymentMethod', 'DateTime', 'CargoType', 'VolumeGeneral', 'Weight', 'ServiceType', 'SeatsAmount',
                'Description', 'Cost', 'CitySender', 'Sender', 'SenderAddress', 'ContactSender', 'SendersPhone',
                'CityRecipient', 'Recipient', 'RecipientAddress', 'ContactRecipient', 'RecipientsPhone'], 'required'],


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

            [['ref'], 'string', 'max' => 32],
            [['ref'], 'string'],
            [['ref'], 'trim'],
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
