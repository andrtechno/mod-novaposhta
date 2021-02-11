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
        $('#expressinvoice-optionsseat-0-volumetricweight').val('0.5');
        $('#expressinvoice-optionsseat-0-volumetricheight').val('10');
        $('#expressinvoice-optionsseat-0-volumetricwidth').val('12');
        $('#expressinvoice-optionsseat-0-volumetriclength').val('17');
        message = 'Шаблон применен.';
    } else if(temp === 2) {
        $('#expressinvoice-optionsseat-0-volumetricweight').val('1');
        $('#expressinvoice-optionsseat-0-volumetricheight').val('10');
        $('#expressinvoice-optionsseat-0-volumetricwidth').val('17');
        $('#expressinvoice-optionsseat-0-volumetriclength').val('24');
        message = 'Шаблон применен.';
    } else if(temp === 3) {
        $('#expressinvoice-optionsseat-0-volumetricweight').val('2');
        $('#expressinvoice-optionsseat-0-volumetricheight').val('10');
        $('#expressinvoice-optionsseat-0-volumetricwidth').val('24');
        $('#expressinvoice-optionsseat-0-volumetriclength').val('34');
        message = 'Шаблон применен.';
    }else{
        $('#expressinvoice-optionsseat-0-volumetricweight').val('');
        $('#expressinvoice-optionsseat-0-volumetricheight').val('');
        $('#expressinvoice-optionsseat-0-volumetricwidth').val('');
        $('#expressinvoice-optionsseat-0-volumetriclength').val('');
        message = 'Шаблон очищен.';
    }
    if(message)
        common.notify(message,'success');

    return false;
}

", \yii\web\View::POS_END);


?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5><?= Html::encode($this->context->pageName) ?></h5>
                </div>
                <div class="card-body">
                    <?php
                    $tabs[] = [
                        'label' => Html::icon('upload') . ' ' . Yii::t('novaposhta/default', 'RECIPIENT'),
                        'content' => $this->render('tabs/_recipient', ['form' => $form, 'model' => $model]),
                        'headerOptions' => [],
                        'options' => ['class' => 'flex-sm-fill text-center nav-item'],
                    ];
                    $tabs[] = [
                        'label' => Html::icon('download') . ' ' . Yii::t('novaposhta/default', 'SENDER'),
                        'content' => $this->render('tabs/_sender', ['form' => $form, 'model' => $model, 'api' => $api]),
                        'headerOptions' => [],
                        'options' => ['class' => 'flex-sm-fill text-center nav-item'],
                    ];


                    echo \panix\engine\bootstrap\Tabs::widget([
                        'encodeLabels' => false,
                        'options' => [
                            'class' => 'nav-pills flex-column flex-sm-row nav-tabs-static'
                        ],
                        'items' => $tabs,
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5>Параметры отправления</h5>
                </div>
                <div class="card-body" style="background-color: #f6f6f6;">


                    <div class="text-center mt-3">
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
                    <?php


                    echo \panix\ext\multipleinput\MultipleInput::widget([
                        'model' => $model,
                        'attribute' => 'OptionsSeat',
                        //  'max' => 7,
                        'min' => 1,
                        'cloneButton' => true,
                        'allowEmptyList' => false,
                        'enableGuessTitle' => true,
                        //'addButtonPosition' => \panix\ext\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
                        'columns' => [

                            [
                                'name' => 'volumetricWeight',
                                'title' => $model::t('WEIGHT'),
                                'enableError' => true,
                                'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
                                'columnOptions' => ['class' => 'text-center'],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                            ],
                            [
                                'name' => 'volumetricHeight',
                                'title' => $model::t('HEIGHT'),
                                'enableError' => true,
                                'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                            ],
                            [
                                'name' => 'volumetricWidth',
                                'title' => $model::t('WIDTH'),
                                'enableError' => true,
                                'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                            ],
                            [
                                'name' => 'volumetricLength',
                                'title' => $model::t('LENGTH'),
                                'enableError' => true,
                                'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                            ]
                        ]
                    ]);


                    ?>
                    <?php // $form->field($model, 'SeatsAmount'); ?>
                    <?= $form->field($model, 'Description')->textarea(); ?>
                    <?= $form->field($model, 'CargoType')->dropDownList($model->cargoTypes()); ?>

                    <div class="form-group row">
                        <div class="col-12">
                            <?php /* $form->field($model, 'Weight', [
                                'template' => '<div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">{label}</div><div class="col-sm-8 col-md-8 col-lg-9 col-xl-8">
                            <div class="input-group">{input}<div class="input-group-append"><span class="input-group-text">кг.</span></div>{hint}{error}</div></div>',
                                'options' => ['class' => ' row']
                            ]);*/
                            ?>

                        </div>
                        <?php if (isset($model->products['weight']) && false) { ?>
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
                            <?php /* $form->field($model, 'VolumeGeneral', [
                                'template' => '<div class="col-sm-4 col-md-4 col-lg-3 col-xl-4">{label}</div><div class="col-sm-8 col-md-8 col-lg-9 col-xl-8">
                            <div class="input-group">{input}<div class="input-group-append"><span class="input-group-text">м³</span></div>{hint}{error}</div></div>',
                                'options' => ['class' => ' row']
                            ]);*/
                            ?>

                        </div>
                        <?php if (isset($model->products['volumeGeneral']) && false) { ?>
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
                <div class="card-footer text-center">
                    <?= Html::submitButton('Создать ЭН', ['class' => 'btn btn-success']); ?>
                </div>
            </div>
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