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


<?php
print_r(Yii::$app->settings->get('novaposhta','templates'));

echo \panix\ext\multipleinput\MultipleInput::widget([
    'model' => $model,
    'attribute' => 'templates',
    //  'max' => 7,
    'min' => 1,
    'cloneButton' => true,
    'allowEmptyList' => false,
    'enableGuessTitle' => true,
    //'addButtonPosition' => \panix\ext\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
    'columns' => [

        [
            'name' => 'volumetricWeight',
            'title' => $model::t('WEIGHT'),
            'enableError' => true,
            'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
            'columnOptions' => ['class' => 'text-center'],
            'headerOptions' => [
                'style' => 'width: 100px;',
            ],
        ],
        [
            'name' => 'volumetricHeight',
            'title' => $model::t('HEIGHT'),
            'enableError' => true,
            'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
            'headerOptions' => [
                'style' => 'width: 100px;',
            ],
        ],
        [
            'name' => 'volumetricWidth',
            'title' => $model::t('WIDTH'),
            'enableError' => true,
            'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
            'headerOptions' => [
                'style' => 'width: 100px;',
            ],
        ],
        [
            'name' => 'volumetricLength',
            'title' => $model::t('LENGTH'),
            'enableError' => true,
            'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
            'headerOptions' => [
                'style' => 'width: 100px;',
            ],
        ]
    ]
]);


?>

