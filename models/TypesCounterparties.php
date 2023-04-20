<?php

namespace panix\mod\novaposhta\models;

use Yii;

/**
 * This is the model class for table "novaposhta_types_counterparties".
 *
 * @property string $Ref Guid
 * @property string $Description
 */
class TypesCounterparties extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__types_counterparties}}';
    }

    public static function loadAll()
    {
        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $response = Yii::$app->novaposhta->getTypesOfCounterparties();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }
}
