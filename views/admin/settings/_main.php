<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use panix\engine\CMS;


/*
$doc = new \simplehtmldom\HtmlWeb();
$html= $doc->load('https://ramosu.com.ua/makiyazh/');
foreach($html->find('.product-thumb .h4-replace a') as $element) {

    $load_product= $doc->load($element->href);
    foreach($load_product->find('.big_image .thumbnail') as $element) {
        CMS::dump($element,30);
       // echo $element->innertext;

        die;
    }


}

die;*/

?>


<?= $form->field($model, 'api_key'); ?>

