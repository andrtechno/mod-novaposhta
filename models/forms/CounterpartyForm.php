<?php

namespace panix\mod\novaposhta\models\forms;

use panix\engine\base\Model;
use Yii;

/**
 * Class CounterpartyForm
 * @package panix\mod\novaposhta\models\forms
 */
class CounterpartyForm extends Model
{

    protected $module = 'novaposhta';
    public static $category = 'novaposhta';

    public $FirstName;
    public $MiddleName;
    public $LastName;
    public $Phone;
    public $Email;
    public $CounterpartyType;
    public $CounterpartyProperty;

    public $OwnershipForm;
    public $EDRPOU;
    public $CityRef;


    public function init()
    {
        parent::init();
    }

    public function save()
    {

        $api = Yii::$app->novaposhta;


    }

    public function rules()
    {
        return [
            [['FirstName', 'LastName', 'Phone', 'CounterpartyType', 'CounterpartyProperty'], 'required'],
            [['MiddleName', 'Email'], 'string'],
            [['FirstName', 'LastName', 'Phone', 'CounterpartyType', 'CounterpartyProperty', 'MiddleName', 'Email','OwnershipForm','EDRPOU','CityRef'], 'string', 'max' => 36],
            ['Email', 'email'],
        ];
    }

}
