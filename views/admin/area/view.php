<?php

use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\novaposhta\models\search\WarehousesSearch;
use panix\engine\grid\GridView;

/**
 * @var \yii\web\View $this
 * @var \panix\mod\novaposhta\models\Cities $model
 */


?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5><?= $this->context->pageName; ?> <span class="float-right">Статус: <span
                                    class="h6 badge badge-secondary">123</span></span></h5>
                </div>
                <div class="card-body p-3">
                    <?php CMS::dump($model->attributes); ?>

                </div>
            </div>
        </div>

    </div>


<?php
