<?php

namespace panix\mod\novaposhta\models;

use panix\mod\novaposhta\models\query\CommonQuery;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "novaposhta_service_types".
 *
 * @property integer $id
 * @property string $Ref
 * @property string $Description
 */
class ServiceTypes extends ActiveRecord
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
        return '{{%novaposhta__service_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description', 'Ref'], 'required'],
            [['Description'], 'string', 'max' => 255],
            [['Description'], 'string'],
            [['Description'], 'trim'],
            [['Description'], 'default'],
        ];
    }


    public static function getList()
    {
        $result = [];
        $list = self::find()->asArray()->all();
        if ($list) {
            foreach ($list as $item) {
                $result[$item['Ref']] = $item['Description'];
            }
        } else {
            $list = Yii::$app->novaposhta->getServiceTypes();
            if ($list['success']) {
                foreach ($list['data'] as $item) {
                    $result[$item['Ref']] = $item['Description'];
                }
            }
        }


        return $result;
    }

    public static function loadAll()
    {
        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $response = Yii::$app->novaposhta->getServiceTypes();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

}
