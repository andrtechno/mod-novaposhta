<?php

use panix\engine\grid\GridView;
use panix\engine\Html;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'layoutOptions' => ['title' => $title],
    'columns' => [
        [
            'attribute' => 'Description',
            'header' => Yii::t('novaposhta/default', 'Description'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model->description . '<br/>' . Html::tag('span', $model->SettlementAreaDescription, ['class' => 'badge badge-success']);
            }
        ],
        [
            'attribute' => 'cityDescription',
            'header' => Yii::t('novaposhta/default', 'CityDescription'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'Reception',
            'header' => Yii::t('novaposhta/default', 'RECEPTION'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                $result = '';
                foreach ($model->getReceptionList() as $day => $value) {
                    if ($value == '-') {
                        $result .= '<strong>' . $day . ':</strong> &mdash;<br>';
                    } else {
                        list($from, $to) = explode('-', $value);
                        $result .= '<strong>' . $day . ':</strong> с ' . $from . ' по ' . $to . '<br>';
                    }

                }
                return $result;
            }
        ],
        [
            'attribute' => 'Schedule',
            'header' => Yii::t('novaposhta/default', 'SCHEDULE'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                $result = '';
                foreach ($model->getScheduleList() as $day => $value) {
                    if ($value == '-') {
                        $result .= '<strong>' . $day . ':</strong> <span class="text-danger">выходной</span><br>';
                    } else {
                        list($from, $to) = explode('-', $value);
                        $result .= '<strong>' . $day . ':</strong> с ' . $from . ' по ' . $to . '<br>';
                    }

                }
                return $result;
            }
        ],
        [
            'attribute' => 'Delivery',
            'header' => Yii::t('novaposhta/default', 'DELIVERY'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                $result = '';
                foreach ($model->getDeliveryList() as $day => $value) {
                    if ($value == '-') {
                        $result .= '<strong>' . $day . ':</strong> &mdash;<br>';
                    } else {
                        list($from, $to) = explode('-', $value);
                        $result .= '<strong>' . $day . ':</strong> с ' . $from . ' по ' . $to . '<br>';
                    }

                }
                return $result;
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
                        'data-pjax' => 0,
                        'class' => 'd-flex align-items-center btn btn-sm btn-outline-secondary']);
                },
            ]
        ]
    ]
]);