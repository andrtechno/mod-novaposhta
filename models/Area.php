<?php

namespace panix\mod\novaposhta\models;

use Yii;

/**
 * This is the model class for table "novaposhta_area".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $DescriptionRu
 * @property string $AreasCenter
 */
class Area extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__area}}';
    }

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }

    public static function getList()
    {
        $result = [];
        $list = self::find()->asArray()->all();
        if ($list) {
            foreach ($list as $item) {
                $result[$item['Ref']] = $item['DescriptionRu'];
            }
        } else {
            $list = Yii::$app->novaposhta->getArea();
            if ($list['success']) {
                foreach ($list['data'] as $item) {
                    $result[$item['Ref']] = $item['DescriptionRu'];
                }
            }
        }


        return $result;
    }
    public static function _loadAll()
    {
        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $response = Yii::$app->novaposhta->getCargoTypes();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }
}
