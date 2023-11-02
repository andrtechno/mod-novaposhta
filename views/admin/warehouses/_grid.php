<?php

use panix\engine\grid\GridView;
use panix\engine\Html;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,

    'layoutOptions' => ['title' => $title],

    'columns' => [
        [
            'attribute' => 'Description',
            'header' => Yii::t('novaposhta/default', 'Description'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model['Description'] . '<br/>' . Html::tag('span', $model['SettlementAreaDescription'], ['class' => 'badge badge-success']);
            }
        ],
        [
            'attribute' => 'CityDescription',
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
                if (isset($model['Reception'])) {
                    $list = [];
                    foreach ($model['Reception'] as $day => $time) {
                        $list[Yii::t('novaposhta/default', $day)] = $time;
                    }

                    foreach ($list as $day => $value) {
                        if ($value == '-') {
                            $result .= '<strong>' . $day . ':</strong> &mdash;<br>';
                        } else {
                            list($from, $to) = explode('-', $value);
                            $result .= '<strong>' . $day . ':</strong> с ' . $from . ' по ' . $to . '<br>';
                        }

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
                if (isset($model['Schedule'])) {
                    $list = [];
                    foreach ($model['Schedule'] as $day => $time) {
                        $list[Yii::t('novaposhta/default', $day)] = $time;
                    }

                    foreach ($list as $day => $value) {
                        if ($value == '-') {
                            $result .= '<strong>' . $day . ':</strong> <span class="text-danger">вихідний</span><br>';
                        } else {
                            list($from, $to) = explode('-', $value);
                            $result .= '<strong>' . $day . ':</strong> с ' . $from . ' по ' . $to . '<br>';
                        }

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
                if (isset($model['Delivery'])) {
                    $list = [];
                    foreach ($model['Delivery'] as $day => $time) {
                        $list[Yii::t('novaposhta/default', $day)] = $time;
                    }
                    foreach ($list as $day => $value) {
                        if ($value == '-') {
                            $result .= '<strong>' . $day . ':</strong> &mdash;<br>';
                        } else {
                            list($from, $to) = explode('-', $value);
                            $result .= '<strong>' . $day . ':</strong> с ' . $from . ' по ' . $to . '<br>';
                        }

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
                    return Html::a(Html::icon('eye'), ['view', 'number' => $model['Number'], 'city' => $model['CityRef']], [
                        'title' => Yii::t('app/default', 'View'),
                        'data-pjax' => 0,
                        'class' => 'd-flex align-items-center btn btn-sm btn-outline-secondary']);
                },
            ]
        ]
    ]
]);
