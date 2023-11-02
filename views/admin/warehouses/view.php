<?php

use panix\engine\CMS;
use panix\engine\Html;

/**
 * @var \yii\web\View $this
 * @var $data
 */
;
if ($data['Latitude'] && $data['Longitude']) {
    \panix\engine\assets\LeafletAsset::register($this);
    $this->registerJs("
    var coords = [" . $data['Latitude'] . ", " . $data['Longitude'] . "];
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
                            class="h6 badge badge-secondary"><?= $data['WarehouseStatus']; ?></span></span></h5>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-sm-7">
                    <?php if ($data['Phone']) { ?>
                        <div>
                            <?= Yii::t('novaposhta/default', 'PHONE'); ?>  <?= Html::tel($data['Phone']); ?>
                        </div>
                    <?php } ?>
                    <div>
                        <?= $data['CategoryOfWarehouse']; ?>
                    </div>

                    <div><?= (Yii::$app->language == 'ru') ? $dara['ShortAddressRu'] : $data['ShortAddress'] ?></div>
                    <div>
                        Вес до: <strong><?= $data['PlaceMaxWeightAllowed']; ?>/<?= $data['TotalMaxWeightAllowed']; ?> кг.</strong>
                    </div>

                    <b>Доступні послуги та сервіси:</b>
                    <ul>
                        <?php if ($data['PostFinance']) { ?>
                            <li>Наличие кассы Пост-Финанс</li>
                        <?php } ?>
                        <?php if ($data['PaymentAccess']) { ?>
                            <li>PaymentAccess</li>
                        <?php } ?>
                        <?php if ($data['SelfServiceWorkplacesCount']) { ?>
                            <li>Зона самообслуговування</li>
                        <?php } ?>
                        <?php if ($data['BicycleParking']) { ?>
                            <li>Велопарковка</li>
                        <?php } ?>
                        <?php if ($data['POSTerminal']) { ?>
                            <li>Оплата карткою</li>
                        <?php } ?>
                        <?php if ($data['InternationalShipping']) { ?>
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
                            <?php
                            $list = [];
                            foreach ($data['Schedule'] as $day => $time) {
                                $list[Yii::t('novaposhta/default', $day)] = $time;
                            }

                            foreach ($list as $schedule) { ?>
                                <td class="text-center"><?= $schedule; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Прийом відправлення для відправки в той же день</td>
                            <?php
                            $list = [];
                            foreach ($data['Delivery'] as $day => $time) {
                                $list[Yii::t('novaposhta/default', $day)] = $time;
                            }

                            foreach ($list as $delivery) { ?>

                                <td class="text-center"><?= $delivery; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Час прибуття відправлення</td>
                            <?php

                            $list = [];
                            foreach ($data['Reception'] as $day => $time) {
                                $list[Yii::t('novaposhta/default', $day)] = $time;
                            }
                            foreach ($list as $reception) { ?>

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
//print_r($data);
