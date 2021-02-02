<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use panix\engine\CMS;

?>


<div class="row">
    <?php foreach ($items as $item) { ?>
        <?php if (isset($item['visible']) && $item['visible'] == true) { ?>
            <div class="col-sm-3">
                <div class="img-thumbnail text-center mb-4">
                    <?=  Html::icon($item['icon'],['style'=>'font-size:40px']); ?>
                    <h4><?= Html::a($item['label'],$item['url']); ?></h4>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

