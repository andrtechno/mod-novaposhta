<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\mod\novaposhta\models\search\WarehousesSearch;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use panix\engine\controllers\AdminController;


class WarehousesController extends AdminController
{


    public function actionIndex()
    {
        $api = Yii::$app->novaposhta;
        $this->pageName = Yii::t('novaposhta/default', 'WAREHOUSES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => '#'
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $searchModel = new WarehousesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionView($id)
    {
        $model = Warehouses::findOne($id);
        $this->pageName = ($model->DescriptionRu) ? $model->DescriptionRu : $model->Description;

        $api = Yii::$app->novaposhta;
        return $this->render('view', ['model' => $model, 'api' => $api]);
    }
}
