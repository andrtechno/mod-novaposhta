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
        if (Yii::$app->request->get('order_id')) {
            $order = Order::findModel(Yii::$app->request->get('order_id'));
            if($order->user_phone)
                $this->recipient_Phone = $order->user_phone;
            if($order->user_address)
                $this->recipient_Warehouse = $order->user_address;
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
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
