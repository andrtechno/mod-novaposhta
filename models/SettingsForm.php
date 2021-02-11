<?php

namespace panix\mod\novaposhta\models;

use panix\engine\CMS;
use panix\engine\SettingsModel;
use Yii;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;

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
    public $templates;

    public function init()
    {

        parent::init();

    }

    public function validateTemplateRequire($attribute)
    {
        $validator = new RequiredValidator();

        if (isset($this->{$attribute}) && $this->{$attribute}) {
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

    public function validateTemplateNumber($attribute)
    {
        $validator = new NumberValidator();
        $validator->integerOnly = false;
        if (isset($this->{$attribute}) && $this->{$attribute}) {
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
    public function rules()
    {
        return [
            ['templates', 'validateTemplateRequire', 'skipOnEmpty' => false],
            ['templates', 'validateTemplateNumber'],
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
