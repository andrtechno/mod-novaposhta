<?php

use panix\engine\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;

Pjax::begin([
    'dataProvider' => $dataProvider,
]);
?>
<?=
GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'Description',
            'header' => Yii::t('novaposhta/default', 'Description'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model->description;
            }
        ],



        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{view}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a(Html::icon('eye'), ['view', 'id' => $model['Ref']], [
                        'title' => Yii::t('app/default', 'View'),

                        'class' => 'd-flex align-items-center btn btn-sm btn-outline-secondary']);
                },
            ]
        ]
    ]
]);
?>
<?php Pjax::end(); ?>