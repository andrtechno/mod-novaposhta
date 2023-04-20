<?php

namespace panix\mod\novaposhta\controllers\admin;

use Yii;
use panix\mod\novaposhta\models\CargoTypes;
use panix\mod\novaposhta\models\OwnershipForms;
use panix\mod\novaposhta\models\Packs;
use panix\mod\novaposhta\models\Pallets;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\Settlements;
use panix\mod\novaposhta\models\TiresWheels;
use panix\mod\novaposhta\models\TypesCounterparties;
use panix\mod\novaposhta\models\TypesOfPayersForRedelivery;
use panix\mod\novaposhta\models\WarehouseTypes;
use panix\mod\novaposhta\models\SettingsForm;
use panix\engine\controllers\AdminController;

class DefaultController extends AdminController
{

    public $icon = 'settings';

    public function actionSettings()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t($this->module->id . '/default', 'MODULE_NAME'),
            'url' => ['index']
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;
        $model = new SettingsForm;

            $this->buttons[] = [
                'label' => Yii::t('novaposhta/admin', 'Add references'),
                'url' => ['add-references'],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-success']
            ];

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
                return $this->refresh();
            }

        }
        $senderData = Yii::$app->novaposhta->getCounterparties('Sender', 1, '', '');
        return $this->render('settings', ['model' => $model, 'senderData' => $senderData]);
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('novaposhta/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $this->buttons[] = [
            'label' => Yii::t('novaposhta/admin', 'Add references'),
            'url' => ['add-references'],
            'icon' => 'add',
            'options' => ['class' => 'btn btn-success']
        ];
        $items = Yii::$app->getModule($this->module->id)->getAdminMenu()['modules']['items'][0]['items'];
        return $this->render('index', ['items' => $items]);
    }

    public function actionAddReferences()
    {

        CargoTypes::loadAll();
        Pallets::loadAll();
        Packs::loadAll();
        OwnershipForms::loadAll();
        TypesOfPayersForRedelivery::loadAll();
        TiresWheels::loadAll();
        TypesCounterparties::loadAll();
        ServiceTypes::loadAll();

        WarehouseTypes::loadAll();
        Settlements::loadAll();
        Yii::$app->session->addFlash('success','Success');
        return $this->redirect(['index']);
    }
}
