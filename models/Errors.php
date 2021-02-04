<?php

namespace panix\mod\novaposhta\models;

/**
 * This is the model class for table "novaposhta_errors".
 *
 * @property int $MessageCode
 * @property string $MessageText
 * @property string $MessageDescriptionRU
 * @property string $MessageDescriptionUA
 */
class Errors extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__errors}}';
    }
}
