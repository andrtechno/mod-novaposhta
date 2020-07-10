<?php

use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

Pjax::begin([
    'dataProvider'=>$dataProvider
]);

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'enableColumns'=>false,
    'columns'=>[
        [
            'attribute' => 'Description',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value'=>function($model){
                return $model->Description.' <code>['.$model->Ref.']</code>';
            }
        ],
    ]
]);

Pjax::end();

