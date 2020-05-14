<?php

use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

Pjax::begin([
    'dataProvider'=>$dataProvider
]);

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'enableColumns'=>false,
    'columns'=>[
        'Description',
        'Ref',

    ]
]);

Pjax::end();

