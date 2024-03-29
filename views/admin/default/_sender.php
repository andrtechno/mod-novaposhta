<?php

use panix\engine\Html;
use panix\mod\novaposhta\models\Cities;
use yii\helpers\ArrayHelper;
use panix\engine\CMS;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\Warehouses;
use panix\ext\select2\Select2;
use panix\ext\telinput\PhoneInput;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $this \yii\web\View
 */


if (!$senderData['success']) { ?>
    <div class="alert alert-danger"><?= $senderData['errors'][0]; ?></div>
    <?php return;
}
//CMS::dump($senderData);die;
$contacts = Yii::$app->novaposhta->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
$contactsList = [];
if ($contacts['success']) {
    foreach ($contacts['data'] as $contact) {
        $contactsList[$contact['Ref']] = $contact;
    }
}
?>


<?= Html::activeHiddenInput($model, 'sender', ['value' => $senderData['data'][0]['Ref']]); ?>
<?= $form->field($model, 'serviceType')->dropDownList(ServiceTypes::getList()) ?>

<?= $form->field($model, 'contact')->dropDownList(ArrayHelper::map($contactsList, 'Ref', function ($data) {
    return $data['Description'] . ', ' . CMS::phone_format($data['Phones']);
}));
?>
<?= $form->field($model, 'sender_phone')->widget(PhoneInput::class, ['value' => $contacts['data'][0]['Phones']]); ?>
<?php // $form->field($model, 'sender_phone')->textInput(['value' => $contacts['data'][0]['Phones']]); ?>
<?= $form->field($model, 'seatsAmount') ?>
<div id="sender-ajax">
    <?php
    $system = new \panix\mod\novaposhta\components\System();
    echo $system->processRequestSender();
    ?>
</div>


<?php

//$test = Yii::$app->novaposhta->getCounterpartyAddresses('db5c88d0-391c-11dd-90d9-001a92567626');
//$model2 = Warehouses::findAll(['CityRef'=>'db5c88d0-391c-11dd-90d9-001a92567626']);
//CMS::dump($model2);
$this->registerCss('
.bootstrap-select .dropdown-menu{max-height:300px;}
');
$this->registerJs("
    var selectedItem = '{$model->sender_warehouse}';
    function loadWarehouses(city_id){
        $.ajax({
            url:'/admin/novaposhta/warehouses/by-city',
            type:'GET',
            data:{id:city_id},
            success:function(data){
                var warehouse = $('#" . Html::getInputId($model, 'sender_warehouse') . "');
                $.each(data.items, function(key, value) {
                    isSelected = (selectedItem == key)?'selected=\"selected\"':'';
                    warehouse.append('<option value=\"'+key+'\" '+isSelected+'>'+value+'</option>');
                });
                warehouse.selectpicker('refresh');
            }
        });
    }


    $('#" . Html::getInputId($model, 'sender_city') . "').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        //console.log(clickedIndex, $(this).val(), previousValue);
        loadWarehouses($(this).val());
    });
    $('#" . Html::getInputId($model, 'sender_city') . "').on('loaded.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        loadWarehouses($(this).val());
    });

");
?>
