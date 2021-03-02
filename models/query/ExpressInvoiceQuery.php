<?php

namespace panix\mod\novaposhta\models\query;

use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;

class ExpressInvoiceQuery extends ActiveQuery
{

    use DefaultQueryTrait;

    public function init()
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->addOrderBy(["{$tableName}.IntDocNumber" => SORT_DESC]);
        parent::init();
    }
}
