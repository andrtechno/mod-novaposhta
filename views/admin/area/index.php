<?php

use panix\engine\Html;
use panix\engine\grid\GridView;

?>
<?=
GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'Description',
            'header' => Yii::t('novaposhta/default', 'AREA'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model['Description'];
            }
        ]
    ]
]);
?>

