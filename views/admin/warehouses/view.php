<?php

use panix\engine\CMS;
use panix\engine\Html;

/**
 * @var \yii\web\View $this
 */


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
icon:markerIcon
}).addTo(map).bindPopup('".$this->context->pageName."');//.openPopup();
    
", \yii\web\View::POS_END);
}
?>


    <div class="card">
        <div class="card-header">
            <h5><?= $this->context->pageName; ?> <span class="float-right">Статус: <span
                            class="h6 badge badge-secondary">asd</span></span></h5>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-sm-6">
                    <div>
                        Телефон  <?= $model->Phone; ?>
                    </div>
                    <div>
                        CategoryOfWarehouse  <?= $model->CategoryOfWarehouse; ?>
                    </div>
                    <?= $model->CityDescription; ?>
                    <?= $model->ShortAddress; ?>
                    <div>
                    <?= $model->PostFinance; ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="leaflet-map" style="width: 100%;height:400px"></div>
                </div>
            </div>

        </div>
    </div>

<?php
