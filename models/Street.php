<?php

namespace panix\mod\novaposhta\models;

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
class Street extends ActiveRecord
{

    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';

    public static function find()
    {
        return new WarehousesQuery(get_called_class());
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta_street}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_description', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['name', 'slug'], 'trim'],
            ['slug', '\panix\engine\validators\UrlValidator', 'attributeCompare' => 'name'],
            ['slug', 'match',
                'pattern' => '/^([a-z0-9-])+$/i',
                'message' => Yii::t('app/default', 'PATTERN_URL')
            ],
            [['updated_at', 'created_at'], 'safe'],


            [['short_description', 'image'], 'default'],
        ];
    }

}
