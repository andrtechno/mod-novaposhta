<?php

namespace panix\mod\novaposhta\models;

use Yii;
/**
 * This is the model class for table "novaposhta_pallets".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $DescriptionRu
 * @property float $Weight
 */
class Pallets extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__pallets}}';
    }

    public static function loadAll()
    {
        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $response = Yii::$app->novaposhta->getPalletsList();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }
}
