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
        $this->breadcrumbs[] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $searchModel = new WarehousesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionView(){
        $api = Yii::$app->novaposhta;
        return $this->render('view',['api'=>$api]);
    }
}
