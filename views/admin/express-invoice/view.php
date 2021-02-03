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
                'url' => $api->printLink('printDocument', [$result['Ref']], 'pdf_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => Yii::t('app/default', 'PRINT') . ' HTML',
                'url' => $api->printLink('printDocument', [$result['Ref']], 'html_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 85x85 ' . Yii::t('app/default', 'PRINT') . ' PDF',
                'url' => $api->printLink('printMarking85x85', [$result['Ref']], 'pdf8_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 85x85 ' . Yii::t('app/default', 'PRINT') . ' HTML',
                'url' => $api->printLink('printMarking85x85', [$result['Ref']], 'html_link'),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 100x100 ' . Yii::t('app/default', 'PRINT') . ' PDF (zebra)',
                'url' => $api->printLink('printMarking100x100', [$result['Ref']], 'pdf_link', true),
                'linkOptions' => ['target' => '_blank']
            ],
            [
                'label' => 'Маркировка 100x100 ' . Yii::t('app/default', 'PRINT') . ' HTML (zebra)',
                'url' => $api->printLink('printMarking100x100', [$result['Ref']], 'html_link', true),
                'linkOptions' => ['target' => '_blank']
            ],
        ],
    ],
]);


?>
    <div class="row">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-header">
                    <h5><?= $this->context->pageName; ?> <span class="float-right">Статус: <span
                                    class="h6 badge badge-secondary"><?= $result['StateName']; ?></span></span></h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Отправитель</th>
                            <th>Получатель</th>
                        </tr>
                        <tr>
                            <td><i class="icon-user-outline"></i> <?= $result['ContactSender']; ?>
                                <br/>
                                <?= Html::a(Html::icon('phone-outline') . ' ' . CMS::phone_format($result['SendersPhone']), 'tel:' . $result['SendersPhone'], ['class' => 'btn btn-sm btn-outline-secondary']); ?>
                            </td>
                            <td><i class="icon-user-outline"></i> <?= $result['ContactRecipient']; ?>
                                <br/>
                                <?= Html::a(Html::icon('phone-outline') . ' ' . CMS::phone_format($result['RecipientsPhone']), 'tel:' . $result['RecipientsPhone'], ['class' => 'btn btn-sm btn-outline-secondary']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="icon-location"></i> Адрес: <?= $result['SenderAddress']; ?></td>
                            <td><i class="icon-location"></i> Адрес: <?= $result['CityRecipient']; ?>
                                , <?= $result['RecipientAddress']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Информация об отправки</h5>
                </div>
                <div class="card-body">


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
                            <th>Цена доставки</th>
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
                            <th><?= Yii::t('novaposhta/default', 'SERVICE_TYPE'); ?></th>
                            <td><?= $result['ServiceType']; ?></td>
                        </tr>
                        <tr>
                            <th>Способ оплаты</th>
                            <td><?= $result['PaymentMethod']; ?></td>
                        </tr>
                        <tr>
                            <th>PayerType.</th>
                            <td><?= $result['PayerType']; ?></td>
                        </tr>
                        <tr>
                            <th>Кол. мест</th>
                            <td><?= $result['SeatsAmount']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">
                    <h5>Трекинг <?= $result['IntDocNumber']; ?>:</h5>
                </div>
                <div class="card-body">
                    <?php
                    $tracking = $api->documentsTracking($result['IntDocNumber']);
                    if ($tracking['success']) { ?>
                        <div class="alert alert-info m-3"><?= $tracking['data'][0]['Status']; ?></div>
                    <?php } ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Обратная доставка</h5>
                </div>
                <div class="card-body">
                    <?php

                    if (isset($result['BackwardDeliveryData'])) {
                        //  CMS::dump($result['BackwardDeliveryData']);
                        $data = $result['BackwardDeliveryData'][0]; ?>
                        <div><?= $data['CargoType']; ?></div>
                        <div><?= $data['PayerType']; ?></div>
                        <div><?= $data['RedeliveryString']; ?>
                            <?php if ($data['CargoTypeRef'] == 'Money') { ?>
                                грн.
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>


<?php


//CMS::dump($result);


$deliveryDate = $api->getDocumentDeliveryDate($result['CitySenderRef'], $result['CityRecipientRef'], $result['ServiceTypeRef'], $result['DateTime']);

//CMS::dump($deliveryDate);


$documentPrice = $api->getDocumentPrice($result['CitySenderRef'], $result['CityRecipientRef'], $result['ServiceTypeRef'], $result['Weight'], $result['Cost'], $result['CargoTypeRef']);
//CMS::dump($documentPrice);

$ei = \panix\mod\novaposhta\models\ExpressInvoice::find()->where(['Ref' => $result['Ref']])->one();
if ($ei && $ei->orderItem && false) { ?>
    <div class="card">
        <?= $ei->orderItem->id; ?>

    </div>

<?php }


