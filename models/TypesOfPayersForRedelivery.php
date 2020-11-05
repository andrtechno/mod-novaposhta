<?php

namespace panix\mod\novaposhta\models;

/**
 * This is the model class for table "novaposhta_types_payers_redelivery".
 *
 * @property string $Ref Guid
 * @property string $Description
 */
class TypesOfPayersForRedelivery extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta_types_payers_redelivery}}';
    }

}
