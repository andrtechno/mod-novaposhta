<?php

namespace panix\mod\novaposhta\models;

use Yii;

/**
 * This is the model class for table "novaposhta_tires_wheels".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $FullName
 */
class OwnershipForms extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__ownership_forms}}';
    }

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }
}
