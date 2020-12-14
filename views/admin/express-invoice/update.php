<?php
use panix\engine\Html;
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
                <h4 class="m-2">Отправитель</h4>
                <?= $form->field($model, 'CitySender'); ?>
                <?= $form->field($model, 'SenderAddress'); ?>
                <?= $form->field($model, 'ContactSender'); ?>
                <?= $form->field($model, 'SendersPhone')->widget(PhoneInput::class); ?>

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
                <?= $form->field($model, 'RecipientAddress'); ?>

            </div>
            <div class="col-sm-6">
                <h4 class="m-2">Параметры отправления</h4>
                <?= $form->field($model, 'ServiceType')->dropDownList($model->serviceTypesList()) ?>
                <?= $form->field($model, 'Cost'); ?>
                <?= $form->field($model, 'DateTime')->widget(\panix\engine\jui\DatePicker::class, [
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
                        'minDate' => 0,
                    ],
                    'dateFormat' => 'php:d.m.Y'
                ]); ?>

                <?= $form->field($model, 'SeatsAmount'); ?>
                <?= $form->field($model, 'Description')->textarea(); ?>
                <?= $form->field($model, 'CargoType')->dropDownList($model->cargoTypes()); ?>
                <div class="form-group row required">
                    <div class="col-sm-4 col-lg-2">
                        <?= Html::activeLabel($model, 'Weight', ['class' => 'col-form-label']); ?>
                    </div>
                    <div class="col-sm-8 col-lg-10">
                        <div class="input-group">
                            <?= Html::activeTextInput($model, 'Weight', ['class' => 'form-control']); ?>
                            <div class="input-group-append">
                                <span class="input-group-text">кг</span>
                            </div>
                        </div>
                    </div>
                </div>


                <?= $form->field($model, 'VolumeGeneral'); ?>
                <?= $form->field($model, 'PayerType')->dropDownList(['Recipient' => Yii::t('novaposhta/default','RECIPIENT'), 'Sender' => Yii::t('novaposhta/default','SENDER')]) ?>
                <?= $form->field($model, 'PaymentMethod')->dropDownList($model->paymentFormsList()) ?>
            </div>
            <div class="col-sm-6">
                <h4 class="m-2">Обратная доставка</h4>
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
