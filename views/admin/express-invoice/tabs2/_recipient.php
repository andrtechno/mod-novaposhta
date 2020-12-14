<?php
use panix\engine\CMS;
use panix\ext\telinput\PhoneInput;
use panix\engine\Html;
use yii\helpers\ArrayHelper;
use panix\mod\novaposhta\models\Warehouses;
use panix\mod\novaposhta\models\Cities;
use panix\ext\bootstrapselect\BootstrapSelect;
/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \panix\mod\novaposhta\models\ExpressInvoiceForm $model
 */


?>


<?php echo $form->field($model, 'RecipientFirstName'); ?>
<?= $form->field($model, 'RecipientLastName'); ?>
<?= $form->field($model, 'RecipientMiddleName'); ?>
<?php
if ($model->RecipientPhone) {
    $call = Html::a(Html::icon('phone') . ' Позвонить &mdash; <strong>' . CMS::phoneOperator($model->RecipientPhone) . '</strong>', 'tel:' . $model->RecipientPhone, ['class' => 'mt-2 mt-lg-0 float-none float-lg-right btn btn-light']);
} else {
    $call = '';
}
?>
<?= $form->field($model, 'RecipientEmail'); ?>
<?= $form->field($model, 'RecipientPhone', [
    'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{hint}\n{beginWrapper}{input}{call}\n{error}{endWrapper}",
    'parts' => [
        '{call}' => $call
    ]
])->widget(PhoneInput::class); ?>


<?= $form->field($model, 'RecipientCity')->widget(BootstrapSelect::class, [
    'items' => ArrayHelper::map(Cities::find()->all(), 'Ref', 'DescriptionRu'),
    'jsOptions' => ['liveSearch' => true],
    'options' => ['data-size' => 10]
]); ?>


<?= $form->field($model, 'RecipientRegion'); ?>



<?= $form->field($model, 'RecipientAddress')->widget(BootstrapSelect::class, [
    'items' => Warehouses::getList($model->RecipientCity),
    'jsOptions' => ['liveSearch' => true],
    'options' => ['data-size' => 10]
]); ?>
