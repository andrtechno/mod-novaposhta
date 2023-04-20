<?php

namespace panix\mod\novaposhta\models;


use Yii;
use panix\engine\db\ActiveRecord;
use panix\mod\novaposhta\models\query\CommonQuery;

/**
 * This is the model class for table "novaposhta".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $DescriptionRu
 */
class WarehouseTypes extends ActiveRecord
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
        return '{{%novaposhta__warehousetypes}}';
    }

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    public static function loadAll()
    {
        $result = Yii::$app->novaposhta->model('Address')
            ->method('getWarehouseTypes')
            ->execute();

        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $fields = ['Ref', 'Description', 'DescriptionRu'];
        if ($result['success']) {
            $data = [];
            foreach ($result['data'] as $city) {
                $data[] = [
                    $city['Ref'],
                    $city['Description'],
                    $city['DescriptionRu']
                ];

            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), $fields, $data)->execute();
        }
    }

}
