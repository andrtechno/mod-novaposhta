<?php

use panix\engine\Html;
use panix\mod\novaposhta\models\Cities;
use yii\helpers\ArrayHelper;
use panix\engine\CMS;
use panix\mod\novaposhta\models\Area;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\Warehouses;
use panix\ext\bootstrapselect\BootstrapSelect;
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $this \yii\web\View
 */

$senderData = Yii::$app->novaposhta->getCounterparties('Sender', 1, '', '');
//CMS::dump($senderData['data']);
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
<?= $form->field($model, 'sender_phone')->textInput(['value' => $contacts['data'][0]['Phones']]); ?>
<?= $form->field($model, 'sender_area')->dropDownList(Area::getList()); ?>
<?= $form->field($model, 'sender_city')->widget(BootstrapSelect::class, [
    'items' => Cities::getList(['IsBranch' => 1]),
    'jsOptions' => ['liveSearch' => true]
]); ?>


<?= $form->field($model, 'sender_warehouse')->widget(BootstrapSelect::class, [
    'items' => [],
    'jsOptions' => ['liveSearch' => true]
]); ?>


<?php

//$test = Yii::$app->novaposhta->getCounterpartyAddresses('3a2b18fc-94a7-11e9-9937-005056881c6b');

//CMS::dump($test);
$this->registerCss('
.bootstrap-select .dropdown-menu{max-height:300px;}
');
$this->registerJs("
    function loadWarehouses(city_id){
        $.ajax({
            url:'/admin/novaposhta/default/get-warehouses',
            type:'GET',
            data:{city_id:city_id},
            success:function(data){
                var warehouse = $('#".Html::getInputId($model,'sender_warehouse')."');
                $.each(data, function(key, value) {
                    warehouse.append('<option value=\"'+key+'\" selected=\"\">'+value+'</option>');
                });
                warehouse.selectpicker('refresh');
            }
        });
    }


    $('#".Html::getInputId($model,'sender_city')."').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        //console.log(clickedIndex, $(this).val(), previousValue);
        loadWarehouses($(this).val());
    });
    $('#".Html::getInputId($model,'sender_city')."').on('loaded.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        loadWarehouses($(this).val());
    });

");
?>