<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\engine\CMS;
CMS::dump($api->getTypesOfCounterparties());
$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'phone')->widget(\panix\ext\telinput\PhoneInput::class); ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'type')->dropDownList($typesList) ?>
        <?= $form->field($model, 'property')->textInput(['value'=>'Recipient']) ?>

    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
