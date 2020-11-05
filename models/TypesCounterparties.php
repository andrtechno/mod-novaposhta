<?php

namespace panix\mod\novaposhta\models;

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
        return '{{%novaposhta_types_counterparties}}';
    }

}
