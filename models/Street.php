<?php

namespace panix\mod\novaposhta\models;

/**
 * This is the model class for table "novaposhta_street".
 *
 * @property string $Ref Guid
 * @property string $Description
 */
class Street extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta_street}}';
    }

}
