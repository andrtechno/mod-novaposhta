<?php

use panix\engine\CMS;
use panix\ext\telinput\PhoneInput;
use panix\engine\Html;
use panix\mod\cart\components\delivery\DeliverySystemManager;
use panix\mod\cart\models\Delivery;
use yii\helpers\ArrayHelper;
use panix\mod\novaposhta\models\Warehouses;
use panix\mod\novaposhta\models\Cities;
use panix\ext\select2\Select2;
use panix\mod\novaposhta\models\Area;

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
        // 'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{hint}\n{beginWrapper}{input}{call}\n{error}{endWrapper}",
        'parts' => [
            '{call}' => $call
        ]
    ])->widget(PhoneInput::class, [
        'jsOptions' => [
            'autoPlaceholder' => 'off'
        ]
    ]); ?>
<?php } ?>

<?php //echo $form->field($model, 'recipient_Region'); ?>
<?php
if (Yii::$app->request->get('order_id')) {
    $area = Area::findOne($model->RecipientRegionRef);
    ?>
    <div class="form-group row">
        <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">
            <span class="col-form-label"><?= $model->getAttributeLabel('RecipientRegionRef'); ?></span>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8"><?= $area->getDescription(); ?></div>
    </div>
    <?php
} else {
    echo $form->field($model, 'RecipientRegionRef')->widget(Select2::class, [
        'items' => ArrayHelper::map(Area::find()->all(), 'Ref', 'DescriptionRu'),
    ]);
}
?>


<?php
if (Yii::$app->request->get('order_id')) {
    $city = Cities::findOne($model->CityRecipientRef);
    ?>
    <div class="form-group row">
        <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">
            <span class="col-form-label"><?= $model->getAttributeLabel('CityRecipientRef'); ?></span>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8"><?= $city->getDescription(); ?></div>
    </div>
    <?php
} else {
    echo $form->field($model, 'CityRecipientRef')->widget(Select2::class, [
        'items' => ArrayHelper::map(Cities::find()->all(), 'Ref', 'DescriptionRu'),
    ]);
}
?>

<?php
if (Yii::$app->request->get('order_id')) {
    $city = Warehouses::findOne($model->RecipientAddressRef);
    ?>
    <div class="form-group row">
        <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">
            <span class="col-form-label"><?= $model->getAttributeLabel('RecipientAddressRef'); ?></span>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8"><?= $city->getDescription(); ?></div>
    </div>
    <?php
} else {
    echo $form->field($model, 'RecipientAddressRef')->widget(Select2::class, [
        'items' => Warehouses::getList($model->CityRecipient),
    ]);
}
?>
    <div id="delivery-form">
        <?php

        /*$order = \panix\mod\cart\models\Order::findOne(Yii::$app->request->get('order_id'));

        //if (!Yii::$app->request->post() && !$model->isNewRecord && $order->delivery_id) {
            $delivery = Delivery::findOne($order->delivery_id);
            if ($delivery->system) {
                $manager = new DeliverySystemManager();
                $system = $manager->getSystemClass($delivery->system);
                $order->deliveryModel = $system->getModel();
            }

       // }

        if ($order->delivery_id) {
            $delivery = \panix\mod\cart\models\Delivery::findOne($order->delivery_id);
            $system = $delivery->getDeliverySystemClass();
            if ($system instanceof \panix\mod\cart\components\delivery\BaseDeliverySystem) {
                echo $system->processRequestAdmin2($delivery, $order);
            }
        }*/
        ?>
    </div>
<?php
//$test = Yii::$app->novaposhta->getCounterpartyAddresses('3a2b18fc-94a7-11e9-9937-005056881c6b');


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