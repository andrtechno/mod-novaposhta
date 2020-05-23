<?php

namespace panix\mod\novaposhta\models;

use panix\engine\CMS;
use panix\engine\SettingsModel;
use Yii;

/**
 * Class SettingsForm
 * @package panix\mod\novaposhta\models
 */
class SettingsForm extends SettingsModel
{

    protected $module = 'novaposhta';
    public static $category = 'novaposhta';

    public $api_key;
    public $contact;

    public $serviceType;
    public $sender;
    public $sender_phone;
    public $sender_area;
    public $sender_city;
    public $sender_warehouse;
    public $seatsAmount;

    public function init()
    {

        parent::init();

    }

    public function rules()
    {
        return [
            [['api_key'], 'required'],
            [['contact', 'serviceType', 'sender', 'sender_phone', 'sender_area', 'sender_city', 'sender_warehouse','seatsAmount'], 'string'],
            // ['comments', 'boolean'],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'api_key' => '',
            'contact' => '',
            'sender' => '',
            'sender_phone' => '',
            'sender_warehouse' => '',
        ];
    }


    public static function paymentFormsList()
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

    public static function cargoTypes()
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
