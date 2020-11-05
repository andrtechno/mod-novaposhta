<?php

namespace panix\mod\novaposhta\models;

use panix\mod\novaposhta\models\query\CommonQuery;
use yii\db\ActiveRecord;

class CommonActiveRecord extends ActiveRecord
{
    const MODULE_ID = 'novaposhta';

    public static function find()
    {
        return new CommonQuery(get_called_class());
    }
}