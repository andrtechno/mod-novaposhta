<?php

namespace panix\mod\novaposhta\models;

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
class Area extends ActiveRecord
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
        return '{{%novaposhta_area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules2()
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

    public static function getList(){
        $result = [];
        $list = self::find()->asArray()->all();
        if($list){
            foreach ($list as $item) {
                $result[$item['Ref']] = $item['DescriptionRu'];
            }
        }else{
            $list = Yii::$app->novaposhta->getArea();
            if ($list['success']) {
                foreach ($list['data'] as $item) {
                    $result[$item['Ref']] = $item['DescriptionRu'];
                }
            }
        }


        return $result;
    }

}
