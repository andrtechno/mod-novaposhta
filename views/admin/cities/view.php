<?php

use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\novaposhta\models\search\WarehousesSearch;
use panix\engine\grid\GridView;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\models\Cities $model
 */

//CMS::dump($model->streets);

?>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5><?= $this->context->pageName; ?></h5>
                </div>
                <div class="card-body p-3">
                    <?php CMS::dump($model->attributes); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <?php

            $searchModel = new WarehousesSearch();
            $dataProvider = $searchModel->search(\yii\helpers\ArrayHelper::merge(Yii::$app->request->getQueryParams(), ['WarehousesSearch' => ['CityRef' => $model->Ref]]));
            //$dataProvider = $searchModel->search(\yii\helpers\ArrayHelper::merge(Yii::$app->request->getQueryParams(),['CityRef'=>$model->Ref]));

            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-striped'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,

                'layoutOptions' => ['title' => 'Склады'],
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
                    /* [
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
                    ],*/

                    [
                        'class' => 'panix\engine\grid\columns\ActionColumn',
                        'template' => '{view}',
                        'header' => Yii::t('app/default', 'OPTIONS'),
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a(Html::icon('eye'), ['/novaposhta/admin/warehouses/view', 'id' => $model['Ref']], [
                                    'title' => Yii::t('app/default', 'View'),

                                    'class' => 'd-flex align-items-center btn btn-sm btn-outline-secondary']);
                            },
                        ]
                    ]
                ]
            ]);

            ?>
        </div>
    </div>


<?php
