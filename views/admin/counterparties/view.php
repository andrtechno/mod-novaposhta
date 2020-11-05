<?php

use panix\engine\Html;
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

?>
<div class="pages-view">

    <h1>123</h1>


    <?php

    /*echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]);*/


    echo GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

        'layoutOptions' => ['title' => 'Контактные лица контрагента'],
        'columns' => [
            [
                'attribute' => 'Phones',
                'header' => Yii::t('novaposhta/default', 'PHONE'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Html::tel($model['Phones']);
                }
            ],
            [
                'attribute' => 'Email',
                'header' => Yii::t('novaposhta/default', 'Email'),
                'format' => 'email',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'Description',
                'header' => Yii::t('novaposhta/default', 'DESCRIPTION'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'FirstName',
                'header' => Yii::t('novaposhta/default', 'FIRST_NAME'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'LastName',
                'header' => Yii::t('novaposhta/default', 'LAST_NAME'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'MiddleName',
                'header' => Yii::t('novaposhta/default', 'MIDDLE_NAME'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
            ],

            [
                'class' => 'panix\engine\grid\columns\ActionColumn',
                'template' => '{update}',
                'header' => Yii::t('app/default', 'OPTIONS'),
                'buttons' => [
                    'update' => function ($url, $model, $key) use ($counterpartyRef) {
                        return Html::a(Html::icon('edit'), ['update', 'id' => $model['Ref'],'counterpartyRef'=>$counterpartyRef], [
                            'title' => Yii::t('app/default', 'UPDATE'),

                            'class' => 'd-flex align-items-center btn btn-sm btn-outline-secondary']);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a(Html::icon('eye'), ['view', 'id' => $model['Ref']], [
                            'title' => Yii::t('app/default', 'View'),

                            'class' => 'd-flex align-items-center btn btn-sm btn-outline-secondary']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(Html::icon('delete'), ['delete', 'id' => $model['Ref']], [
                            'title' => Yii::t('app/default', 'DELETE'),
                            'data-confirm' => 'yes?',
                            'class' => 'd-flex align-items-center btn btn-sm btn-outline-danger']);
                    },

                ]
            ]
        ]
    ]);

    ?>

</div>
