<?php

use panix\engine\CMS;
use panix\engine\Html;


?>
<?php
//DateTime
//echo CMS::date(strtotime($result['DateTime']));


?>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= Yii::t('app/default', 'PRINT'); ?>
    </button>
    <div class="dropdown-menu">
        <?= Html::a(Html::icon('print').' '.Yii::t('app/default', 'PRINT').' PDF','https://my.novaposhta.ua/orders/printDocument/orders[]/'.$result['Ref'].'/type/pdf/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'),['class'=>'dropdown-item','target'=>'_blank']); ?>
        <?= Html::a(Html::icon('print').' '.Yii::t('app/default', 'PRINT').' HTML','https://my.novaposhta.ua/orders/printDocument/orders[]/'.$result['Ref'].'/type/html/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'),['class'=>'dropdown-item','target'=>'_blank']); ?>
        <?= Html::a(Html::icon('print').' Маркировка 85x85 '.Yii::t('app/default', 'PRINT').' PDF','https://my.novaposhta.ua/orders/printMarking85x85/orders[]/'.$result['Ref'].'/type/pdf8/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'),['class'=>'dropdown-item','target'=>'_blank']); ?>
        <?= Html::a(Html::icon('print').' Маркировка 85x85 '.Yii::t('app/default', 'PRINT').' HTML','https://my.novaposhta.ua/orders/printMarking85x85/orders[]/'.$result['Ref'].'/type/html/apiKey/'.Yii::$app->settings->get('novaposhta','api_key'),['class'=>'dropdown-item','target'=>'_blank']); ?>
        <?= Html::a(Html::icon('print').' Маркировка 100x100 '.Yii::t('app/default', 'PRINT').' PDF (zebra)','https://my.novaposhta.ua/orders/printMarking100x100/orders[]/'.$result['Ref'].'/type/pdf/apiKey/'.Yii::$app->settings->get('novaposhta','api_key').'/zebra',['class'=>'dropdown-item','target'=>'_blank']); ?>
        <?= Html::a(Html::icon('print').' Маркировка 100x100' .Yii::t('app/default', 'PRINT').' HTML (zebra)','https://my.novaposhta.ua/orders/printMarking100x100/orders[]/'.$result['Ref'].'/type/html/apiKey/'.Yii::$app->settings->get('novaposhta','api_key').'/zebra',['class'=>'dropdown-item','target'=>'_blank']); ?>
    </div>

<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName; ?> <span class="float-right">Статус: <span class="h6 badge badge-secondary"><?= $result['StateName']; ?></span></span></h5>
    </div>
    <div class="card-body p-3">
        <div class="row">
            <div class="col-sm-6">
                <h4>Отправитель: <small class="text-muted"><?= $result['Sender']; ?></small></h4>
                <div><i class="icon-user-outline"></i> <?= $result['ContactSender']; ?>, <?= Html::tel($result['SendersPhone']); ?></div>
                <div><i class="icon-location"></i> Адрес: <?= $result['SenderAddress']; ?></div>

            </div>
            <div class="col-sm-6">
                <h4>Получатель: <small class="text-muted"><?= $result['Recipient']; ?></small></h4>
                <div><i class="icon-user-outline"></i> <?= $result['ContactRecipient']; ?> <?= Html::a(Html::icon('phone-outline') . ' ' . CMS::phone_format($result['RecipientsPhone']), 'tel:' . $result['RecipientsPhone'], ['class' => 'btn btn-sm btn-outline-secondary']); ?></div>
                <div><i class="icon-location"></i> Адрес: <?= $result['CityRecipient']; ?>, <?= $result['RecipientAddress']; ?></div>
            </div>
            <div class="col-sm-6">
                <h4>Обратная доставка</h4>
                <?php
                if(isset($result['BackwardDeliveryData'])){
                    $data= $result['BackwardDeliveryData'][0];

                    echo $data['CargoType'];
                    echo $data['PayerType'];
                    echo $data['RedeliveryString'];
                    // CMS::dump($result['BackwardDeliveryData'][0]);
                }
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
                        <td><?= CMS::date(strtotime($result['DateTime']),true,'UTC'); ?></td>
                    </tr>
                    <tr>
                        <th>Объем куб.м.</th>
                        <td><?= $result['VolumeGeneral']; ?></td>
                    </tr>

                    <tr>
                        <th>Тип груза</th>
                        <td><?= $result['CargoType']; ?> <?php

                            $s = \panix\mod\novaposhta\models\CargoTypes::findOne($result['CargoTypeRef']);
                           echo $s->Description;
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


        </div>
    </div>
</div>

<?php
CMS::dump($result);

$deliveryDate = $api->getDocumentDeliveryDate($result['CitySenderRef'],$result['CityRecipientRef'],$result['ServiceTypeRef'],$result['DateTime']);

//CMS::dump($deliveryDate);



$documentPrice = $api->getDocumentPrice($result['CitySenderRef'],$result['CityRecipientRef'],$result['ServiceTypeRef'],$result['Weight'],$result['Cost'], $result['CargoTypeRef']);
//CMS::dump($documentPrice);




$tracking = $api->documentsTracking($result['Ref']);
//CMS::dump($tracking);
