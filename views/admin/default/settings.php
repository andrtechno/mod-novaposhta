<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\mod\shop\models\ProductType;
use yii\helpers\ArrayHelper;
use panix\engine\CMS;
use yii\httpclient\Client;

?>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5><?= $this->context->pageName ?></h5>
            </div>
            <?php
            $form = ActiveForm::begin([
                    'id'=>'settings-form',
                'fieldConfig' => [
                    'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-form-label',
                        'offset' => 'offset-sm-4 offset-lg-3 offset-xl-4',
                        'wrapper' => 'col-sm-8 col-md-8 col-lg-9 col-xl-8',
                        'error' => '',
                        'hint' => '',
                    ],
                ]
                ]);
            ?>
            <div class="card-body">


                <?php
                echo panix\engine\bootstrap\Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('novaposhta/default', 'COMMON'),
                            'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
                            'active' => true,
                        ],
                        [
                            'label' => Yii::t('novaposhta/default', 'DEPARTURE'),
                            'content' => $this->render('_sender', ['form' => $form, 'model' => $model, 'senderData' => $senderData]),
                            'headerOptions' => [],
                        ],
                        [
                            'label' => Yii::t('novaposhta/default', 'TEMPLATES_SEAT'),
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
                <div class="alert alert-info m-3">Для постоянного обновление базы новой почты, необходимо запустить CRON
                    задачи
                </div>
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
                            <code>php cmd novaposhta/novaposhta/reference</code>
                            <div class="text-muted">Дополнительные справочники.</div>
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
