<?php

namespace panix\mod\novaposhta\models;

use panix\engine\SettingsModel;

/**
 * Class SettingsForm
 * @package panix\mod\novaposhta\models
 */
class SettingsForm extends SettingsModel
{

    protected $module = 'novaposhta';
    public static $category = 'novaposhta';

    public $api_key;
   // public $comments;

    public function rules()
    {
        return [
            ['api_key', 'required'],
           // ['comments', 'boolean'],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'api_key' => '',

        ];
    }
}
