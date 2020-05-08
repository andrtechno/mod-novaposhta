<?php
use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;


$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'PayerType')->dropDownList(['Recipient' => 'Recipient','Sender' => 'Sender']) ?>
    </div>
    <div class="col-sm-6">

        <?= $form->field($model, 'PaymentMethod')->dropDownList($model->paymentFormsList()) ?>
        <?= $form->field($model, 'ServiceType')->dropDownList($model->serviceTypesList()) ?>
        <?= $form->field($model, 'Cost'); ?>
        <?= $form->field($model, 'SeatsAmount'); ?>
        <?= $form->field($model, 'Description')->textarea(); ?>
        <?= $form->field($model, 'CargoType')->dropDownList($model->cargoTypes()); ?>
        <?= $form->field($model, 'Weight'); ?>
        <?= $form->field($model, 'VolumeGeneral'); ?>
    </div>
    <div class="col-sm-6">
        das
    </div>
    <div class="col-sm-6">
        das
    </div>
</div>
        <?php

        //$s = $api->getPaymentForms();
       // \panix\engine\CMS::dump($s);

        ?>



    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
