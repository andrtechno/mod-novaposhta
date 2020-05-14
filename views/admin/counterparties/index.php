<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;




$data = $api->getCounterparties();



CMS::dump($data);
