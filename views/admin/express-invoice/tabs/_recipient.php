<?php

use panix\engine\CMS;
use panix\ext\telinput\PhoneInput;
use panix\engine\Html;
use panix\mod\cart\models\Delivery;
use yii\helpers\ArrayHelper;
use panix\mod\novaposhta\models\Cities;
use panix\ext\select2\Select2;

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


<div id="delivery-recipient-form">
    <?php

    $system = new \panix\mod\novaposhta\components\System();

        echo $system->processRequestRecipient($model);


    ?>
</div>




