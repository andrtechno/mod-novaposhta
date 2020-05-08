<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
use panix\engine\CMS;

$data = $api->getDocumentList();

CMS::dump($data);

print_r($api->printGetLink('printDocument',['1fcc5694-910e-11ea-8513-b88303659df5'],'pdf_link'));

die;