<?php

namespace panix\mod\novaposhta\models;


use Yii;
use panix\engine\db\ActiveRecord;
use panix\mod\novaposhta\models\query\CommonQuery;

/**
 * This is the model class for table "novaposhta_cargo_types".
 *
 * @property string $Ref Guid
 * @property string $Description
 */
class CargoTypes extends ActiveRecord
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
        return '{{%novaposhta_cargo_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Ref'], 'required'],
            [['Description'], 'string', 'max' => 255],
        ];
    }

}
