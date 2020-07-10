<?php

use panix\engine\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;

Pjax::begin([
   // 'dataProvider' => $dataProvider,
]);
?>
<?=
GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'IntDocNumber',
            'header' => Yii::t('novaposhta/default', 'TTN'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'ServiceType',
            'header' => Yii::t('novaposhta/default', 'ServiceType'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{view}{delete}{print}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a(Html::icon('eye'), ['view','id'=>$model['Ref']], [
                        'title' => Yii::t('app/default', 'View'),

                        'class' => 'btn btn-sm btn-outline-secondary']);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a(Html::icon('delete'), ['delete','id'=>$model['Ref']], [
                        'title' => Yii::t('app/default', 'DELETE'),

                        'class' => 'btn btn-sm btn-outline-danger']);
                },
                'print' => function ($url, $model, $key) {

                    // $result = $api->printDocument(['4eb9b43e-9432-11ea-8513-b88303659df5'],'pdf_link')

                   /* return Html::a(Html::icon('print').' HTML', 'https://my.novaposhta.ua/orders/printDocument/orders[]/'.$model['Ref'].'/type/html/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'), [
                        'title' => Yii::t('app/default', 'PRINT'),
                        'target'=>'_blank',
                        'class' => 'btn btn-sm btn-outline-secondary']);
*/


                    return '
           
  <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    '.Yii::t('app/default', 'PRINT').'
  </button>
  <div class="dropdown-menu">
  '.Html::a(Html::icon('print').' '.Yii::t('app/default', 'PRINT').' PDF','https://my.novaposhta.ua/orders/printDocument/orders[]/'.$model['Ref'].'/type/pdf/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'),['class'=>'dropdown-item','target'=>'_blank']).'
  '.Html::a(Html::icon('print').' '.Yii::t('app/default', 'PRINT').' HTML','https://my.novaposhta.ua/orders/printDocument/orders[]/'.$model['Ref'].'/type/html/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'),['class'=>'dropdown-item','target'=>'_blank']).'
  </div>
';


                },
            ]
        ]
    ]
]);
?>
<?php Pjax::end(); ?>