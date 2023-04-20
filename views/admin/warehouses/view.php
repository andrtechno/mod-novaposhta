<?php

use panix\engine\CMS;
use panix\engine\Html;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\models\Warehouses $model
 */
//CMS::dump($model->attributes);
if ($model->Latitude && $model->Longitude) {
    \panix\engine\assets\LeafletAsset::register($this);
    $this->registerJs("
    var coords = [" . $model->Latitude . ", " . $model->Longitude . "];
var map = L.map('leaflet-map', {
    center: coords,
    zoom: 13
});


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors'
}).addTo(map);
//L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
//attribution: 'CartoDB'
//}).addTo(map);

var markerIcon = L.icon({
    iconUrl: 'http://pixelion.com.ua/uploads/YWIYuQTR9H.png',
    iconSize: [38, 95],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
    //shadowUrl: 'my-icon-shadow.png',
    //shadowSize: [68, 95],
    //shadowAnchor: [22, 94]
});

L.marker(coords,{
//icon:markerIcon
}).addTo(map).bindPopup('" . $this->context->pageName . "');//.openPopup();
    
", \yii\web\View::POS_END);
}
?>


    <div class="card">
        <div class="card-header">
            <h5><?= $this->context->pageName; ?> <span class="float-right">Статус: <span
                            class="h6 badge badge-secondary"><?= $model->WarehouseStatus; ?></span></span></h5>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-sm-7">
                    <?php if ($model->Phone) { ?>
                        <div>
                            <?= Yii::t('novaposhta/default', 'PHONE'); ?>  <?= Html::tel($model->Phone); ?>
                        </div>
                    <?php } ?>
                    <div>
                        <?= $model->CategoryOfWarehouse; ?>
                    </div>

                    <?php
                    //$s = \panix\mod\novaposhta\models\ServiceTypes::findOne(['Ref'=>$model->TypeOfWarehouse]);
                    // CMS::dump($s);
                    ?>
                    <div><?= $model->getShortAddress(); ?></div>
                    <div>
                        Вес до: <strong><?= $model->PlaceMaxWeightAllowed; ?> кг.</strong>
                    </div>

                    <b>Доступні послуги та сервіси:</b>
                    <ul>
                        <?php if ($model->PostFinance) { ?>
                            <li>Наличие кассы Пост-Финанс</li>
                        <?php } ?>
                        <?php if ($model->PaymentAccess) { ?>
                            <li>PaymentAccess</li>
                        <?php } ?>
                        <?php if ($model->SelfServiceWorkplacesCount) { ?>
                            <li>Зона самообслуговування</li>
                        <?php } ?>
                        <?php if ($model->BicycleParking) { ?>
                            <li>Велопарковка</li>
                        <?php } ?>
                        <?php if ($model->POSTerminal) { ?>
                            <li>Оплата карткою</li>
                        <?php } ?>
                        <?php if ($model->InternationalShipping) { ?>
                            <li>Возможность оформления Международного отправления</li>
                        <?php } ?>


                    </ul>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width: 25%"></th>
                            <th class="text-center">ПН</th>
                            <th class="text-center">ВТ</th>
                            <th class="text-center">СР</th>
                            <th class="text-center">ЧТ</th>
                            <th class="text-center">ПТ</th>
                            <th class="text-center text-danger">СБ</th>
                            <th class="text-center text-danger">НД</th>
                        </tr>


                        <tr>
                            <td class="font-weight-bold">Графік роботи</td>
                            <?php foreach ($model->getScheduleList() as $schedule) { ?>
                                <td class="text-center"><?= $schedule; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Прийом відправлення для відправки в той же день</td>
                            <?php foreach ($model->getDelivery() as $delivery) { ?>

                                <td class="text-center"><?= $delivery; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Час прибуття відправлення</td>
                            <?php foreach ($model->getReceptions() as $reception) { ?>

                                <td class="text-center"><?= $reception; ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-5">
                    <div id="leaflet-map" style="width: 100%;height:400px"></div>
                </div>
            </div>

        </div>
    </div>

<?php
