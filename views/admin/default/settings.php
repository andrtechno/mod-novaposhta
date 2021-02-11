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
<div class="row">
    <div class="col-sm-6">
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
                            'label' => Yii::t('novaposhta/default','COMMON'),
                            'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
                            'active' => true,
                        ],
                        [
                            'label' => Yii::t('novaposhta/default','DEPARTURE'),
                            'content' => $this->render('_sender', ['form' => $form, 'model' => $model]),
                            'headerOptions' => [],
                        ],
                        [
                            'label' => Yii::t('novaposhta/default','TEMPLATES_SEAT'),
                            'content' => $this->render('_template', ['form' => $form, 'model' => $model]),
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

    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5><?= $this->context->pageName ?></h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info m-3">Для постоянного обновление базы новой почты, необходимо запустить CRON задачи</div>
                <table class="table table-striped">
                    <tr>
                        <th>Комманда</th>
                        <th class="text-center">Рек. периуд</th>
                    </tr>
                    <tr>
                        <td>
                            <code>php cmd novaposhta/novaposhta/cities</code>
                            <div class="text-muted">Обновление городов.</div>
                        </td>
                        <td class="text-center">
                            0 0 * * 0
                            <div class="text-muted">(Раз в неделю)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <code>php cmd novaposhta/novaposhta/warehouses</code>
                            <div class="text-muted">Обновление складов.</div>
                        </td>
                        <td class="text-center">
                            0 0 * * 0
                            <div class="text-muted">(Раз в неделю)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <code>php cmd novaposhta/novaposhta/reference</code>
                            <div class="text-muted">Дополнительные справочники.</div>
                        </td>
                        <td class="text-center">
                            0 0 1 * *
                            <div class="text-muted">(Раз в месяц)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <code>php cmd novaposhta/novaposhta/area</code>
                            <div class="text-muted">Области.</div>
                        </td>
                        <td class="text-center">
                            0 0 1 * *
                            <div class="text-muted">(Раз в месяц)</div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
