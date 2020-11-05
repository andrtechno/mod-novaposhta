<?php

namespace panix\mod\novaposhta\models;

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
}
