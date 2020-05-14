<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\mod\shop\models\ProductType;
use yii\helpers\ArrayHelper;
use panix\engine\CMS;
use yii\httpclient\Client;

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

<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <?php
    $form = ActiveForm::begin();
    ?>
    <div class="card-body">


        <?php
        echo panix\engine\bootstrap\Tabs::widget([
            'items' => [
                [
                    'label' => 'Общие',
                    'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
                    'active' => true,
                ],
                [
                    'label' => 'Отправление',
                    'content' => $this->render('_sender', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ],

            ],
        ]);
        ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
