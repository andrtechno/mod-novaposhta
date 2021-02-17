<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\ext\telinput\PhoneInput;

$form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'offset' => 'offset-sm-4 offset-lg-3 offset-xl-4',
            'wrapper' => 'col-sm-8 col-md-8 col-lg-9 col-xl-8',
        ],
    ]
]);

?>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5><?= Html::encode($this->context->pageName) ?></h5>
            </div>
            <div class="card-body">
                <?php
                $tabs[] = [
                    'label' => Html::icon('upload') . ' ' . Yii::t('novaposhta/default', 'RECIPIENT'),
                    'content' => $this->render('tabs/_recipient', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                    'options' => ['class' => 'flex-sm-fill text-center nav-item'],
                ];
                $tabs[] = [
                    'label' => Html::icon('download') . ' ' . Yii::t('novaposhta/default', 'SENDER'),
                    'content' => $this->render('tabs/_sender', ['form' => $form, 'model' => $model, 'api' => $api]),
                    'headerOptions' => [],
                    'options' => ['class' => 'flex-sm-fill text-center nav-item'],
                ];


                echo \panix\engine\bootstrap\Tabs::widget([
                    'encodeLabels' => false,
                    'options' => [
                        'class' => 'nav-pills flex-column flex-sm-row nav-tabs-static'
                    ],
                    'items' => $tabs,
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5><?= Html::encode($this->context->pageName) ?></h5>
            </div>
            <div class="card-body" style="background-color: #f6f6f6;">


                <?= $this->render('_form', ['model' => $model, 'form' => $form]); ?>


            </div>
            <div class="card-footer text-center">
                <?= Html::submitButton(Yii::t('app/default','UPDATE'), ['class' => 'btn btn-success']); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
