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
$phone = '';
if ($senderData['success']) {


    $contacts = $api->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
    $contactsList = [];
    if ($contacts['success']) {
        foreach ($contacts['data'] as $contact) {
            $contactsList[$contact['Ref']] = $contact;
            $phone = $contact['Phones'];
        }
    }


} else {
    throw new ErrorException($senderData['errors'][0]);
}
$config = Yii::$app->settings->get('novaposhta');
if (isset($config->city)) {
    $model->CitySenderRef = $config->sender_city;
}
if (isset($config->warehouse)) {
    $model->SenderAddressRef = $config->sender_warehouse;
}
?>



<?= $form->field($model, 'ContactSender')->dropDownList(ArrayHelper::map($contactsList, 'Ref', function ($data) {
    return $data['Description'] . ', ' . CMS::phone_format($data['Phones']);
}));
?>

<div id="sender-ajax">
    <?php
    $system = new \panix\mod\novaposhta\components\System();
    echo $system->processRequestSender();

    ?>
</div>


<?php if ($model->isNewRecord) { ?>
    <?php
    $model->SendersPhone = (strpos('+', $phone)) ? $phone : '+' . $phone;
    ?>
    <?= $form->field($model, 'SendersPhone')->widget(PhoneInput::class); ?>
<?php } ?>

