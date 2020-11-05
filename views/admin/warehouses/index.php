<?php

use panix\engine\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\models\Warehouses $model
 */

Pjax::begin([
    'dataProvider' => $dataProvider,
]);
?>
<?php
echo $this->render('_grid', [
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
    'title' => $this->context->pageName
]);
?>
<?php Pjax::end(); ?>