<?php
use panix\engine\CMS;
use panix\ext\bootstrapselect\BootstrapSelect;
use panix\ext\telinput\PhoneInput;
use yii\helpers\ArrayHelper;

/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap4\ActiveForm $form
 * @var \panix\mod\novaposhta\models\ExpressInvoiceForm $model
 */


$senderData = $api->getCounterparties('Sender', 1, '', '');
//CMS::dump($senderData['data']);
$contacts = $api->getCounterpartyContactPersons($senderData['data'][0]['Ref']);
$contactsList = [];
if ($contacts['success']) {
    foreach ($contacts['data'] as $contact) {
        $contactsList[$contact['Ref']] = $contact;
    }
}


?>



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