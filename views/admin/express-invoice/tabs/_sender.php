<?php

use panix\engine\CMS;
use panix\ext\select2\Select2;
use panix\ext\telinput\PhoneInput;
use yii\helpers\ArrayHelper;
use panix\engine\Html;

/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \panix\mod\novaposhta\models\ExpressInvoiceForm $model
 */


$senderData = $api->getCounterparties('Sender', 1, '', '');

if ($senderData['success']) {


    $contacts = $api->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
    $contactsList = [];
    if ($contacts['success']) {
        foreach ($contacts['data'] as $contact) {
            $contactsList[$contact['Ref']] = $contact;
        }
    }


}else{
    throw new ErrorException($senderData['errors'][0]);
}

?>



<?= $form->field($model, 'ContactSender')->dropDownList(ArrayHelper::map($contactsList, 'Ref', function ($data) {
    return $data['Description'] . ', ' . CMS::phone_format($data['Phones']);
}));
?>
<?= $form->field($model, 'CitySenderRef')->widget(Select2::class, [
    'items' => \panix\mod\novaposhta\models\Cities::getList(['IsBranch' => 1]),
    'clientOptions' => [],
    'options' => []
]); ?>


<?= $form->field($model, 'SenderAddressRef')->widget(Select2::class, [
    'items' => \panix\mod\novaposhta\models\Warehouses::getList(Yii::$app->settings->get('novaposhta', 'sender_city')),
    'clientOptions' => [],
    'options' => []
]); ?>


<?php if ($model->isNewRecord) { ?>
    <?= $form->field($model, 'SendersPhone')->widget(PhoneInput::class); ?>
<?php } ?>

<?php

$this->registerJs("
    $('#" . Html::getInputId($model, 'CitySenderRef') . "').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    console.log(clickedIndex, $(this).val(), previousValue);
    $(this).selectpicker('val');
    $.ajax({
        url:'/admin/novaposhta/warehouses/by-city',
        type:'GET',
        data:{id:$(this).val()},
        success:function(data){
            console.log(data);
            
            var warehouse = $('#" . Html::getInputId($model, 'SenderAddressRef') . "');
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
