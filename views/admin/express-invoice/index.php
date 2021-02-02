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
    'rowOptions' => function ($model, $index, $widget, $grid) {
        $date = new \DateTime($model['DateTime'], new \DateTimeZone('Europe/Kiev'));
        $now = (int)$date->format('U');
        $options = (($now + 60 * 5) >= time()) ? ['style' => 'background-color:#b2f9c7;'] : [];
        return $options;
    },
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'IntDocNumber',
            'header' => Yii::t('novaposhta/default', '№'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'ServiceType',
            'header' => Yii::t('novaposhta/default', 'SERVICE_TYPE'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'CostOnSite',
            'header' => Yii::t('novaposhta/default', 'DELIVERY_COST'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model) {
                return $model['CostOnSite'] . ' грн.';
            }
        ],
        [
            'attribute' => 'Description',
            'header' => Yii::t('novaposhta/default', 'DESCRIPTION'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'RecipientAddress',
            'header' => Yii::t('novaposhta/default', 'RECIPIENT_ADDRESS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model['CityRecipient'] . ' &mdash; <br/>' . $model['RecipientAddress'];

            }

        ],
        [
            'attribute' => 'SenderAddress',
            'header' => Yii::t('novaposhta/default', 'SENDER_ADDRESS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model['CitySender'] . ' &mdash; <br/>' . $model['SenderAddress'];
            }
        ],


        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{view}{delete}{print}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
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
                'print' => function ($url, $model, $key) use ($api) {

                    // $result = $api->printDocument(['4eb9b43e-9432-11ea-8513-b88303659df5'],'pdf_link')

                    /* return Html::a(Html::icon('print').' HTML', 'https://my.novaposhta.ua/orders/printDocument/orders[]/'.$model['Ref'].'/type/html/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'), [
                         'title' => Yii::t('app/default', 'PRINT'),
                         'target'=>'_blank',
                         'class' => 'btn btn-sm btn-outline-secondary']);
 */

                    return \panix\engine\bootstrap\ButtonDropdown::widget([
                        'label' => Html::icon('print'),
                        'buttonOptions' => ['class' => 'btn btn-outline-secondary'],
                        'encodeLabel' => false,
                        'dropdown' => [
                            'items' => [
                                [
                                    'label' => Yii::t('app/default', 'PRINT') . ' PDF',
                                    'url' => $api->printLink('printDocument', [$model['Ref']], 'pdf_link'),
                                    'linkOptions' => ['target' => '_blank']
                                ],
                                [
                                    'label' => Yii::t('app/default', 'PRINT') . ' HTML',
                                    'url' => $api->printLink('printDocument', [$model['Ref']], 'html_link'),
                                    'linkOptions' => ['target' => '_blank']
                                ],
                                [
                                    'label' => 'Маркировка 85x85 ' . Yii::t('app/default', 'PRINT') . ' PDF',
                                    'url' => $api->printLink('printMarking85x85', [$model['Ref']], 'pdf8_link'),
                                    'linkOptions' => ['target' => '_blank']
                                ],
                                [
                                    'label' => 'Маркировка 85x85 ' . Yii::t('app/default', 'PRINT') . ' HTML',
                                    'url' => $api->printLink('printMarking85x85', [$model['Ref']], 'html_link'),
                                    'linkOptions' => ['target' => '_blank']
                                ],
                                [
                                    'label' => 'Маркировка 100x100 ' . Yii::t('app/default', 'PRINT') . ' PDF (zebra)',
                                    'url' => $api->printLink('printMarking100x100', [$model['Ref']], 'pdf_link', true),
                                    'linkOptions' => ['target' => '_blank']
                                ],
                                [
                                    'label' => 'Маркировка 100x100 ' . Yii::t('app/default', 'PRINT') . ' HTML (zebra)',
                                    'url' => $api->printLink('printMarking100x100', [$model['Ref']], 'html_link', true),
                                    'linkOptions' => ['target' => '_blank']
                                ],
                            ],
                        ],
                    ]);
                },
            ]
        ]
    ]
]);
?>
<?php Pjax::end(); ?>