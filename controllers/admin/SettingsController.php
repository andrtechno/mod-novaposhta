<?php

namespace panix\mod\novaposhta\controllers\admin;

use Yii;
use panix\mod\novaposhta\models\SettingsForm;
use panix\engine\controllers\AdminController;

class SettingsController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => '#'
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;
        $model = new SettingsForm;

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            }
            return $this->refresh();
        }

        return $this->render('index', ['model' => $model]);
    }

}
