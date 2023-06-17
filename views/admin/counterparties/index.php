<?php

use panix\engine\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\components\Novaposhta $api
 */



$all = $api->getCounterparties();


$senders = $api->getCounterparties('Sender');
$recipient = $api->getCounterparties('Recipient');
//CMS::dump($senders);

if ($all['success']) {

    $dataProvider = new \yii\data\ArrayDataProvider([
        'allModels' => $all['data'],
        'pagination' => [
            'pageSize' => 100,
        ],
        //  'sort' => $sort,
    ]);


    Pjax::begin([]);
    echo GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

        'layoutOptions' => ['title' => 'Контактные лица контрагента'],
        'columns' => [
            [
                'attribute' => 'Description',
                'header' => Yii::t('novaposhta/default', 'DESCRIPTION'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'CounterpartyType',
                'header' => Yii::t('novaposhta/default', 'CounterpartyType'),
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'class' => 'panix\engine\grid\columns\ActionColumn',
                'template' => '{view}{delete}',
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

                ]
            ]
        ]
    ]);
    Pjax::end();
}
?>
<?php
//CMS::dump($test);die;

/*
//Получение сроков доставки
$sender_city = $api->getCity('Белгород-Днестровский', 'Одесская');
$sender_city_ref = $sender_city['data'][0]['Ref'];
// Получение кода города по названию города и области
$recipient_city = $api->getCity('Киев', 'Киевская');
$recipient_city_ref = $recipient_city['data'][0]['Ref'];
// Дата отправки груза
$date = date('d.m.Y');
// Получение ориентировочной даты прибытия груза между складами в разных городах
$result = $api->getDocumentDeliveryDate($sender_city_ref, $recipient_city_ref, 'WarehouseWarehouse', $date);


//Получение стоимости доставки
$sender_city = $api->getCity('Белгород-Днестровский', 'Одесская');
$sender_city_ref = $sender_city['data'][0]['Ref'];
// Получение кода города по названию города и области
$recipient_city = $api->getCity('Киев', 'Киевская');
$recipient_city_ref = $recipient_city['data'][0]['Ref'];
// Вес товара
$weight = 1;
// Цена в грн
$price = 2450;
// Получение стоимости доставки груза с указанным весом и стоимостью между складами в разных городах
$result = $api->getDocumentPrice($sender_city_ref, $recipient_city_ref, 'WarehouseWarehouse', $weight, $price, 'Cargo');


CMS::dump($result);*/
