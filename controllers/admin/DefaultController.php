<?php

namespace panix\mod\novaposhta\controllers\admin;

use Yii;
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

        $items = Yii::$app->getModule($this->module->id)->getAdminMenu()['modules']['items'][0]['items'];
        return $this->render('index', ['items' => $items]);
    }

}
