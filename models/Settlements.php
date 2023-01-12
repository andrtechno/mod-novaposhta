<?php

namespace panix\mod\novaposhta\models;

/**
 * This is the model class for table "novaposhta_cargo_types".
 *
 * @property string $Ref Guid
 * @property string $Description
 */
class Settlements extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__settlements}}';
    }


}
