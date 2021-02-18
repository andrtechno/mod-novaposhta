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

<?php if ($model->isNewRecord) { ?>
    <?= $form->field($model, 'recipient_FirstName'); ?>
    <?= $form->field($model, 'recipient_LastName'); ?>
    <?= $form->field($model, 'recipient_MiddleName'); ?>
    <?= $form->field($model, 'recipient_Email'); ?>

<?php
    //todo: bug input tel format AND senderphone
if ($model->RecipientsPhone) {
    $call = Html::a(Html::icon('phone') . ' Позвонить', 'tel:' . $model->RecipientsPhone, ['class' => 'mt-2 mt-lg-0 float-none float-lg-right btn btn-light']);
} else {
    $call = '';
}
?>
<?= $form->field($model, 'RecipientsPhone', [
    'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{hint}\n{beginWrapper}{input}{call}\n{error}{endWrapper}",
    'parts' => [
        '{call}' => $call
    ]
])->widget(PhoneInput::class,[
    'jsOptions' => [
        'autoPlaceholder' => 'off'
    ]
]); ?>
<?php } ?>


<?= $form->field($model, 'CityRecipientRef')->widget(BootstrapSelect::class, [
    'items' => ArrayHelper::map(Cities::find()->all(), 'Ref', 'DescriptionRu'),
    'jsOptions' => ['liveSearch' => true],
    'options' => ['data-size' => 10]
]); ?>


<?= $form->field($model, 'recipient_Region'); ?>



<?= $form->field($model, 'RecipientAddressRef')->widget(BootstrapSelect::class, [
    'items' => Warehouses::getList($model->CityRecipient),
    'jsOptions' => ['liveSearch' => true],
    'options' => ['data-size' => 10]
]); ?>
<?php

//$test = Yii::$app->novaposhta->getCounterpartyAddresses('3a2b18fc-94a7-11e9-9937-005056881c6b');

//CMS::dump($test);
$this->registerJs("
    $('#" . Html::getInputId($model, 'CityRecipientRef') . "').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    console.log(clickedIndex, $(this).val(), previousValue);
    $(this).selectpicker('val');
    $.ajax({
        url:'/admin/novaposhta/warehouses/by-city',
        type:'GET',
        data:{id:$(this).val()},
        success:function(data){
            var warehouse = $('#" . Html::getInputId($model, 'RecipientAddressRef') . "');
            warehouse.html('');
            $.each(data.items, function(key, value) {
                warehouse.append('<option value=\"'+key+'\" selected=\"\">'+value+'</option>');
            });

            warehouse.selectpicker('refresh');
       
        }
    });
});


");
?>