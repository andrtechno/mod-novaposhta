<?php
use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\ext\telinput\PhoneInput;



$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <h4 class="m-2">Получатель</h4>
                <?= $form->field($model, 'recipient_FirstName'); ?>
                <?= $form->field($model, 'recipient_LastName'); ?>
                <?= $form->field($model, 'recipient_MiddleName'); ?>
                <?= $form->field($model, 'recipient_Phone')->widget(PhoneInput::class); ?>
                <?= $form->field($model, 'recipient_City'); ?>
                <?= $form->field($model, 'recipient_Region'); ?>
                <?= $form->field($model, 'recipient_Email'); ?>
                <?= $form->field($model, 'recipient_Warehouse'); ?>

            </div>
            <div class="col-sm-6">
                <h4>Параметры отправления</h4>
                <?= $form->field($model, 'ServiceType')->dropDownList($model->serviceTypesList()) ?>
                <?= $form->field($model, 'Cost'); ?>
                <?= $form->field($model, 'DateTime')->widget(\panix\engine\jui\DatePicker::className(), [
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear'  => true,
                        'minDate'     => 0,

                    ],
                    'dateFormat'=> 'php:m.d.Y'
                ]); ?>

                <?= $form->field($model, 'SeatsAmount'); ?>
                <?= $form->field($model, 'Description')->textarea(); ?>
                <?= $form->field($model, 'CargoType')->dropDownList($model->cargoTypes()); ?>
                <?= $form->field($model, 'Weight'); ?>
                <?= $form->field($model, 'VolumeGeneral'); ?>
                <?= $form->field($model, 'PayerType')->dropDownList(['Recipient' => 'Recipient', 'Sender' => 'Sender']) ?>
                <?= $form->field($model, 'PaymentMethod')->dropDownList($model->paymentFormsList()) ?>
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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
