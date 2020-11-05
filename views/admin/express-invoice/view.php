<?php

use panix\engine\CMS;
use panix\engine\Html;


?>
<?php
//DateTime
//echo CMS::date(strtotime($result['DateTime']));

echo \panix\engine\bootstrap\ButtonDropdown::widget([
    'label' => Html::icon('print') . ' ' . Yii::t('app/default', 'PRINT'),
    'buttonOptions' => ['class' => 'btn btn-outline-secondary'],
    'encodeLabel' => false,
    'dropdown' => [
        'items' => [
            [
                'label' => Yii::t('app/default', 'PRINT') . ' PDF',
                'url' => $api->printLink('printDocument', [$model['Ref']], 'pdf_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => Yii::t('app/default', 'PRINT') . ' HTML',
                'url' => $api->printLink('printDocument', [$model['Ref']], 'html_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 85x85 ' . Yii::t('app/default', 'PRINT') . ' PDF',
                'url' => $api->printLink('printMarking85x85', [$model['Ref']], 'pdf8_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 85x85 ' . Yii::t('app/default', 'PRINT') . ' HTML',
                'url' => $api->printLink('printMarking85x85', [$model['Ref']], 'html_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 100x100 ' . Yii::t('app/default', 'PRINT') . ' PDF (zebra)',
                'url' => $api->printLink('printMarking100x100', [$model['Ref']], 'pdf_link', true),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 100x100 ' . Yii::t('app/default', 'PRINT') . ' HTML (zebra)',
                'url' => $api->printLink('printMarking100x100', [$model['Ref']], 'html_link', true),
                'linkOptions' => ['target' => '_blank']
            ],
        ],
    ],
]);


?>

    <div class="card">
        <div class="card-header">
            <h5><?= $this->context->pageName; ?> <span class="float-right">Статус: <span
                            class="h6 badge badge-secondary"><?= $result['StateName']; ?></span></span></h5>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Отправитель:
                        <small class="text-muted"><?= $result['Sender']; ?></small>
                    </h4>
                    <div><i class="icon-user-outline"></i> <?= $result['ContactSender']; ?>
                        , <?= Html::tel($result['SendersPhone']); ?></div>
                    <div><i class="icon-location"></i> Адрес: <?= $result['SenderAddress']; ?></div>

                </div>
                <div class="col-sm-6">
                    <h4>Получатель:
                        <small class="text-muted"><?= $result['Recipient']; ?></small>
                    </h4>
                    <div>
                        <i class="icon-user-outline"></i> <?= $result['ContactRecipient']; ?> <?= Html::a(Html::icon('phone-outline') . ' ' . CMS::phone_format($result['RecipientsPhone']), 'tel:' . $result['RecipientsPhone'], ['class' => 'btn btn-sm btn-outline-secondary']); ?>
                    </div>
                    <div><i class="icon-location"></i> Адрес: <?= $result['CityRecipient']; ?>
                        , <?= $result['RecipientAddress']; ?></div>
                </div>
                <div class="col-sm-6">
                    <h4>Обратная доставка</h4>
                    <?php
                    if (isset($result['BackwardDeliveryData'])) {
                        $data = $result['BackwardDeliveryData'][0]; ?>
                        <div><?= $data['CargoType']; ?></div>
                        <div><?= $data['PayerType']; ?></div>
                        <div><?= $data['RedeliveryString']; ?></div>
                    <?php } ?>
                    <?php


                    ?>

                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <h4>Информация об отправки:</h4>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Вес</th>
                            <td><strong><?= $result['Weight']; ?></strong> кг.</td>
                        </tr>
                        <tr>
                            <th>Цена</th>
                            <td><strong><?= $result['Cost']; ?></strong> грн.</td>
                        </tr>
                        <tr>
                            <th>Цена доствки</th>
                            <td><strong><?= $result['CostOnSite']; ?></strong> грн.</td>
                        </tr>
                        <tr>
                            <th>Дата создания</th>
                            <td><?= CMS::date(strtotime($result['DateTime']), true, 'UTC'); ?></td>
                        </tr>
                        <tr>
                            <th>Объем куб.м.</th>
                            <td><?= $result['VolumeGeneral']; ?></td>
                        </tr>

                        <tr>
                            <th>Тип груза</th>
                            <td><?= $result['CargoType']; ?><?php

                                $s = \panix\mod\novaposhta\models\CargoTypes::findOne($result['CargoTypeRef']);
                                if ($s) {
                                    echo $s->Description;
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>ServiceType.</th>
                            <td><?= $result['ServiceType']; ?> ServiceTypeRef</td>
                        </tr>
                        <tr>
                            <th>Способ оплаты</th>
                            <td><?= $result['PaymentMethod']; ?> PaymentMethodRef</td>
                        </tr>
                        <tr>
                            <th>PayerType.</th>
                            <td><?= $result['PayerType']; ?> PayerTypeRef</td>
                        </tr>
                        <tr>
                            <th>Кол. мест</th>
                            <td><?= $result['SeatsAmount']; ?></td>
                        </tr>
                    </table>


                </div>
                <div class="col-sm-6">
                    <h4>Трекинг <?= $result['IntDocNumber']; ?>:</h4>
                    <?php
                    $tracking = $api->documentsTracking($result['IntDocNumber']);
                    if ($tracking['success']) { ?>
                        <div class="alert alert-info"><?= $tracking['data'][0]['Status']; ?></div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

<?php


CMS::dump($result);


$deliveryDate = $api->getDocumentDeliveryDate($result['CitySenderRef'], $result['CityRecipientRef'], $result['ServiceTypeRef'], $result['DateTime']);

//CMS::dump($deliveryDate);


$documentPrice = $api->getDocumentPrice($result['CitySenderRef'], $result['CityRecipientRef'], $result['ServiceTypeRef'], $result['Weight'], $result['Cost'], $result['CargoTypeRef']);
//CMS::dump($documentPrice);


