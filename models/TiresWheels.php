<?php

namespace panix\mod\novaposhta\models;

use Yii;

/**
 * This is the model class for table "novaposhta_tires_wheels".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $DescriptionRu
 * @property double $Weight
 * @property string $DescriptionType
 */
class TiresWheels extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__tires_wheels}}';
    }

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }
}
