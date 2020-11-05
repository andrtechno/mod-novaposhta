<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use panix\mod\novaposhta\models\TypesCounterparties;

$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">

        <?= $form->field($model, 'FirstName')->textInput(['maxlength' => 36]) ?>
        <?= $form->field($model, 'LastName')->textInput(['maxlength' => 36]) ?>
        <?= $form->field($model, 'MiddleName')->textInput(['maxlength' => 36]) ?>
        <?= $form->field($model, 'Phone')->widget(\panix\ext\telinput\PhoneInput::class, [
            'jsOptions' => [
                'onlyCountries' => ['ua']
            ]
        ]); ?>
        <?= $form->field($model, 'Email')->textInput(['maxlength' => 36]) ?>
        <?= $form->field($model, 'CounterpartyType')->dropDownList(ArrayHelper::map(TypesCounterparties::find()->all(), 'Ref', 'Description')) ?>
        <?= $form->field($model, 'CounterpartyProperty')->dropDownList(ArrayHelper::map(\panix\mod\novaposhta\models\TypesOfPayersForRedelivery::find()->all(), 'Ref', 'Description')) ?>
        <?= $form->field($model, 'OwnershipForm')->dropDownList(ArrayHelper::map(\panix\mod\novaposhta\models\OwnershipForms::find()->all(), 'Ref', 'Description'), ['prompt' => '-']) ?>
        <?= $form->field($model, 'EDRPOU')->textInput(['maxlength' => 36]) ?>
        <?= $form->field($model, 'CityRef')->dropDownList(ArrayHelper::map(\panix\mod\novaposhta\models\Cities::find()->all(), 'Ref', 'Description'), ['prompt' => '-']) ?>


    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton('save'); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
