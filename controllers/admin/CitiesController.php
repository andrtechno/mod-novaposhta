<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\mod\novaposhta\models\search\CitiesSearch;
use panix\mod\novaposhta\models\Cities;
use Yii;
use panix\engine\controllers\AdminController;


class CitiesController extends AdminController
{


    public function actionIndex()
    {
        $api = Yii::$app->novaposhta;
        $this->pageName = Yii::t('novaposhta/default', 'CITIES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => '#'
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $searchModel = new CitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionView($id)
    {
        $model = Cities::findOne($id);
        $this->pageName = $model->getDescription();
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => '#'
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'CITIES'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $api = Yii::$app->novaposhta;
        return $this->render('view', ['model' => $model, 'api' => $api]);
    }
}
