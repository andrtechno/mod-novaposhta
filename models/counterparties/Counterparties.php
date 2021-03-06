<?php

namespace panix\mod\novaposhta\models\counterparties;


use panix\mod\novaposhta\models\query\CommonQuery;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "novaposhta__counterparties".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class Counterparties extends ActiveRecord
{

    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';

    public static function find()
    {
        return new CommonQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__counterparties}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'middle_name','phone','email','type','property'], 'required'],
            [['first_name', 'last_name', 'middle_name','phone'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['first_name', 'last_name', 'middle_name'], 'trim'],
            [['updated_at', 'created_at'], 'safe'],


           // [['short_description', 'image'], 'default'],
        ];
    }


}
