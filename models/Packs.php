<?php

namespace panix\mod\novaposhta\models;

/**
 * This is the model class for table "novaposhta_packs".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $DescriptionRu
 * @property double $Length
 * @property double $Width
 * @property double $Height
 * @property double $VolumetricWeight
 * @property string $TypeOfPacking
 */
class Packs extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta_packs}}';
    }
}
