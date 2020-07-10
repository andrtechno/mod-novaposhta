<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\components\Novaposhta $api
 */



$data = $api->getCounterparties('Recipient');
$data = $api->getCounterparties('Sender');




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
$result = $api->getDocumentPrice($sender_city_ref, $recipient_city_ref, 'WarehouseWarehouse', $weight, $price,'Cargo');


CMS::dump($result);
