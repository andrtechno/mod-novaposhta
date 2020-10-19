<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\ext\telinput\PhoneInput;
use panix\engine\CMS;
use yii\helpers\ArrayHelper;
use panix\ext\bootstrapselect\BootstrapSelect;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\models\ExpressInvoiceForm $model
 */
$form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'offset' => 'offset-sm-4 offset-lg-3 offset-xl-4',
            'wrapper' => 'col-sm-8 col-md-8 col-lg-9 col-xl-8',
        ],
    ]
]);

$senderData = $api->getCounterparties('Sender', 1, '', '');
//CMS::dump($senderData['data']);
$contacts = $api->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
$contactsList = [];
if ($contacts['success']) {
    foreach ($contacts['data'] as $contact) {
        $contactsList[$contact['Ref']] = $contact;
    }
}


//$contact = $api->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
//\panix\engine\CMS::dump($contact);
//die;
$this->registerCss('
.bootstrap-select .dropdown-menu{
    /*height:300px;*/
}
');

$this->registerJs("

function setTemplate(temp){
    var message;
    if(temp === 1){
        $('#expressinvoice-weight').val('10');
        $('#expressinvoice-volumegeneral').val('40');
        message = 'Шаблон применен.';
    } else if(temp === 2) {
        $('#expressinvoice-weight').val('20');
        $('#expressinvoice-volumegeneral').val('50');
        message = 'Шаблон применен.';
    } else if(temp === 3) {
        $('#expressinvoice-weight').val('20');
        $('#expressinvoice-volumegeneral').val('50');
        message = 'Шаблон применен.';
    }else{
        $('#expressinvoice-weight').val('');
        $('#expressinvoice-volumegeneral').val('');
        message = 'Шаблон очищен.';
    }
    if(message)
        common.notify(message,'success');

    return false;
}

", \yii\web\View::POS_END);
?>

    <div class="card">
        <div class="card-header">
            <h5><?= Html::encode($this->context->pageName) ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-3 text-center">Отправиль</h4>
                    <?= $form->field($model, 'ContactSender')->dropDownList(ArrayHelper::map($contactsList, 'Ref', function ($data) {
                        return $data['Description'] . ', ' . CMS::phone_format($data['Phones']);
                    }));
                    ?>
                    <?= $form->field($model, 'CitySender')->widget(BootstrapSelect::class, [
                        'items' => \panix\mod\novaposhta\models\Cities::getList(['IsBranch' => 1]),
                        'jsOptions' => ['liveSearch' => true],
                        'options' => ['data-size' => 10]
                    ]); ?>


                    <?= $form->field($model, 'SenderAddress')->widget(BootstrapSelect::class, [
                        'items' => \panix\mod\novaposhta\models\Warehouses::getList(Yii::$app->settings->get('novaposhta', 'sender_city')),
                        'jsOptions' => ['liveSearch' => true],
                        'options' => ['data-size' => 10]
                    ]); ?>



                    <?= $form->field($model, 'SendersPhone')->widget(PhoneInput::class); ?>

                </div>
                <div class="col-sm-6">
                    <h4 class="m-3 text-center">Получатель</h4>
                    <?php echo $form->field($model, 'recipient_FirstName'); ?>
                    <?= $form->field($model, 'recipient_LastName'); ?>
                    <?= $form->field($model, 'recipient_MiddleName'); ?>
                    <?php
                    if ($model->RecipientsPhone) {
                        $call = Html::a(Html::icon('phone') . ' Позвонить &mdash; <strong>' . CMS::phoneOperator($model->RecipientsPhone) . '</strong>', 'tel:' . $model->RecipientsPhone, ['class' => 'mt-2 mt-lg-0 float-none float-lg-right btn btn-light']);
                    } else {
                        $call = '';
                    }
                    ?>
                    <?= $form->field($model, 'RecipientsPhone', [
                        'template' => "<div class=\"col-sm-4 col-md-4 col-lg-3 col-xl-4\">{label}</div>\n{hint}\n{beginWrapper}{input}{call}\n{error}{endWrapper}",
                        'parts' => [
                            '{call}' => $call
                        ]
                    ])->widget(PhoneInput::class); ?>
                    <?= $form->field($model, 'recipient_City'); ?>

                    <?= $form->field($model, 'recipient_Region'); ?>
                    <?= $form->field($model, 'recipient_Email'); ?>
                    <?= $form->field($model, 'RecipientAddress'); ?>

                </div>
                <div class="col-sm-6">
                    <h4 class="m-3 text-center">Параметры отправления</h4>


                    <div class="text-center">
                        <?= Html::a('очистить', '#clear', ['class' => 'btn btn-sm btn-outline-secondary', 'onclick' => 'setTemplate(0);']); ?>
                        <?= Html::a('шаблон №1', '#temp1', ['class' => 'btn btn-sm btn-outline-secondary', 'onclick' => 'setTemplate(1);']); ?>
                        <?= Html::a('шаблон №2', '#temp2', ['class' => 'btn btn-sm btn-outline-secondary', 'onclick' => 'setTemplate(2);']); ?>
                        <?= Html::a('шаблон №3', '#temp3', ['class' => 'btn btn-sm btn-outline-secondary', 'onclick' => 'setTemplate(3);']); ?>
                    </div>
                    <?= $form->field($model, 'ServiceType')->dropDownList(\panix\mod\novaposhta\models\ServiceTypes::getList()) ?>

                    <div class="form-group row required">
                        <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">
                            <?= Html::activeLabel($model, 'Cost', ['class' => 'col-form-label']); ?>
                        </div>
                        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8">
                            <div class="input-group">
                                <?= Html::activeTextInput($model, 'Cost', ['class' => 'form-control']); ?>
                                <div class="input-group-append">
                                    <span class="input-group-text">грн.</span>
                                </div>
                            </div>
                        </div>
                    </div>
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

                    <div class="form-group row">
                        <div class="col-12">
                            <?= $form->field($model, 'Weight', [
                                'template' => '<div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">{label}</div><div class="col-sm-8 col-md-8 col-lg-9 col-xl-8">
                            <div class="input-group">{input}<div class="input-group-append"><span class="input-group-text">кг.</span></div>{hint}{error}</div></div>',
                                'options' => ['class' => ' row']
                            ]);
                            ?>

                        </div>
                        <?php if (isset($model->products['weight'])) { ?>
                            <div class="mt-3">
                                <div class="alert alert-warning">Не указан <strong>Вес.</strong> Данный список
                                    товаров
                                    не учитываеться в общем
                                    списке Веса.
                                    <?php foreach ($model->products['weight'] as $product) { ?>
                                        <div><?= Html::a($product->name, ['/admin/shop/product/update', 'id' => $product->product_id]); ?></div>

                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="form-group row">
                        <div class="col-12">
                            <?= $form->field($model, 'VolumeGeneral', [
                                'template' => '<div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">{label}</div><div class="col-sm-8 col-md-8 col-lg-9 col-xl-8">
                            <div class="input-group">{input}<div class="input-group-append"><span class="input-group-text">м³</span></div>{hint}{error}</div></div>',
                                'options' => ['class' => ' row']
                            ]);
                            ?>

                        </div>
                        <?php if (isset($model->products['volumeGeneral'])) { ?>
                            <div class="mt-3">
                                <div class="alert alert-warning">Не указан <strong>Обьем.</strong> Данный список
                                    товаров не
                                    учитываеться в общем
                                    объеме.
                                    <?php foreach ($model->products['volumeGeneral'] as $product) { ?>
                                        <div><?= Html::a($product->name, ['/admin/shop/product/update', 'id' => $product->product_id]); ?></div>

                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>




                    <?= $form->field($model, 'PayerType')->dropDownList(['Recipient' => Yii::t('novaposhta/default', 'RECIPIENT'), 'Sender' => Yii::t('novaposhta/default', 'SENDER')]) ?>
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
            <?= Html::submitButton('Создать ЭН', ['class' => 'btn btn-success']); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php

//$test = Yii::$app->novaposhta->getCounterpartyAddresses('3a2b18fc-94a7-11e9-9937-005056881c6b');

//CMS::dump($test);
$this->registerJs("
    $('#" . Html::getInputId($model, 'sender_city') . "').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    console.log(clickedIndex, $(this).val(), previousValue);
    $(this).selectpicker('val');
    $.ajax({
        url:'/admin/novaposhta/default/get-warehouses',
        type:'GET',
        data:{city_id:$(this).val()},
        success:function(data){
            console.log(data);
            
            var warehouse = $('#" . Html::getInputId($model, 'sender_warehouse') . "');
            
            
            $.each(data, function(key, value) {
                warehouse.append('<option value=\"'+key+'\" selected=\"\">'+value+'</option>');
            });

            warehouse.selectpicker('refresh');

        
        }
    });
});


");
?>