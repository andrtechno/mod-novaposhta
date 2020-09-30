<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\mod\novaposhta\models\ExpressInvoice;
use panix\mod\novaposhta\models\ExpressInvoiceForm;
use panix\mod\novaposhta\models\search\ServiceTypesSearch;
use Yii;
use panix\engine\controllers\AdminController;


class ServiceTypesController extends AdminController
{

    public function actionIndex()
    {
        $api = Yii::$app->novaposhta;
        $this->pageName = Yii::t('novaposhta/default', 'SERVICES_TYPES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $searchModel = new ServiceTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
