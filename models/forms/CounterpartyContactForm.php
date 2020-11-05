<?php

namespace panix\mod\novaposhta\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use panix\mod\cart\models\Order;
use Yii;

/**
 * Class CounterpartyContactForm
 * @package panix\mod\novaposhta\models\forms
 */
class CounterpartyContactForm extends Model
{

    protected $module = 'novaposhta';
    public static $category = 'novaposhta';

    public $PayerType;
    public $PaymentMethod;
    public $DateTime;


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
            ], 'required'],

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

        ];
    }

}
