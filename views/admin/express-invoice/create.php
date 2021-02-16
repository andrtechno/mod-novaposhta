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
$templates = Yii::$app->settings->get('novaposhta', 'templates');

//$contact = $api->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
//\panix\engine\CMS::dump($contact);
//die;
$this->registerCss('
.bootstrap-select .dropdown-menu{
    /*height:300px;*/
}
');


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


                    <?= $form->field($model, 'ServiceType')->dropDownList(\panix\mod\novaposhta\models\ServiceTypes::getList()) ?>


                    <?= $form->field($model, 'DateTime')->widget(\panix\engine\jui\DatePicker::class, [
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                            'minDate' => 0,
                        ],
                        'dateFormat' => 'php:d.m.Y'
                    ]); ?>



                    <?= $form->field($model, 'Description')->textarea(); ?>
                    <?= $form->field($model, 'CargoType')->dropDownList($model->cargoTypes()); ?>


                    <?= $form->field($model, 'PayerType')->dropDownList(['Recipient' => Yii::t('novaposhta/default', 'RECIPIENT'), 'Sender' => Yii::t('novaposhta/default', 'SENDER')]) ?>
                    <?= $form->field($model, 'PaymentMethod')->dropDownList($model->paymentFormsList()) ?>





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
                    <?php

                    echo '<h4 class="text-center mt-3">Обратная доставка</h4>';

                    echo \panix\ext\multipleinput\MultipleInput::widget([
                        'model' => $model,
                        'attribute' => 'BackwardDeliveryData',
                        //  'max' => 7,
                       // 'min' => 1,
                        // 'cloneButton' => true,
                        'allowEmptyList' => true,
                        'enableGuessTitle' => true,
                        //'addButtonPosition' => \panix\ext\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
                        'columns' => [

                            [
                                'name' => 'PayerType',
                                'type' => 'dropDownList',
                                'title' => $model::t('BackwardDeliveryData_PayerType'),
                                'enableError' => true,
                                'options' => ['class' => 'custom-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
                                'columnOptions' => ['class' => 'text-center'],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                                'items' => [
                                    'Recipient' => 'Получатель',
                                    'Sender' => 'Отправитель'

                                ]
                            ],
                            [
                                'name' => 'CargoType',
                                'type' => 'dropDownList',
                                'title' => $model::t('BackwardDeliveryData_CargoType'),
                                'enableError' => true,
                                'options' => ['class' => 'custom-control m-auto', 'autocomplete' => 'off', 'placeholder' => $model::t('Например: 1.5')],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                                'items' => [
                                    'Money' => 'Money',
                                    //'Trays' => 'Trays',
                                    'Documents' => 'Documents',
                                    'Other' => 'Other'
                                ]
                            ],
                            [
                                'name' => 'RedeliveryString',
                                'title' => $model::t('BackwardDeliveryData_RedeliveryString'),
                                'enableError' => true,
                                'options' => ['class' => 'form-control m-auto', 'autocomplete' => 'off'],
                                'headerOptions' => [
                                    'style' => 'width: 100px;',
                                ],
                            ]
                        ]
                    ]);

                    if ($templates) { ?>
                    <?php
                    $js = <<<JS
$(document).on('click','.btn-template',function(){
    var volumetricweight = $(this).data('volumetricweight');
    var volumetricheight = $(this).data('volumetricheight');
    var volumetricwidth = $(this).data('volumetricwidth');
    var volumetriclength = $(this).data('volumetriclength');
    var message = $(this).data('message');
    
    $('#expressinvoice-optionsseat-0-volumetricweight').val(volumetricweight);
    $('#expressinvoice-optionsseat-0-volumetricheight').val(volumetricheight);
    $('#expressinvoice-optionsseat-0-volumetricwidth').val(volumetricwidth);
    $('#expressinvoice-optionsseat-0-volumetriclength').val(volumetriclength);

    if(message)
        common.notify(message,'success');
    
    return false;
});
JS;

                    $this->registerJs($js, \yii\web\View::POS_END);

                    ?>
                    <div class="text-center mt-3 mb-3">
                        <?= Html::a(Html::icon('delete') . ' Очистить', '#', ['data' => [
                            'message' => 'Шаблон очищен!',
                            'volumetricweight' => '',
                            'volumetricheight' => '',
                            'volumetricwidth' => '',
                            'volumetriclength' => '',
                        ], 'class' => 'btn-template btn btn-sm btn-outline-danger']); ?>
                        <div class="btn-group">
                            <?php
                            foreach (Yii::$app->settings->get('novaposhta', 'templates') as $k => $template) {
                                $name = '' . $template['volumetricWeight'] . "кг. ({$template['volumetricHeight']}в {$template['volumetricWidth']}ш {$template['volumetricLength']}д)";
                                echo Html::a($name/*'Шаблон №' . ($k + 1)*/, '#', ['data' => array_merge($template, ['message' => 'Шаблон применен']), 'class' => 'btn-template btn btn-sm btn-outline-secondary']);
                            }
                            ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php
                    echo '<h4 class="text-center mt-3">Количество мест</h4>';
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