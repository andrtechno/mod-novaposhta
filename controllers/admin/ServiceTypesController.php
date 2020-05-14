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
        $this->pageName = Yii::t('novaposhta/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('novaposhta/default', 'CREATE_BTN'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [
            $this->pageName
        ];

        $searchModel = new ServiceTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    public function actionCreate()
    {

        $api = Yii::$app->novaposhta;
        $model = new ExpressInvoiceForm();

        $model->DateTime = date('d.m.Y');
        $model->SeatsAmount = 1;
        $model->Weight = 1;
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {

                $model->save();
                return $this->redirect(['/admin/novaposhta/express-invoice']);
            } else {
                print_r($model->getErrors());
            }
        }

        return $this->render('create', [
            'model' => $model,
            'api'=>$api,
            //'order'=>$order
        ]);
    }
    public function actionUpdate($id = false)
    {
        $api = Yii::$app->novaposhta;
        $model = ExpressInvoice::findModel($id);
        $this->pageName = Yii::t('novaposhta/default', 'CREATE_BTN');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('novaposhta/default', 'CREATE_BTN'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;
        $isNew = $model->isNewRecord;
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
                return $this->redirectPage($isNew, $post);
            } else {
                // print_r($model->getErrors());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'api'=>$api
        ]);
    }
    public function actionView(){
        $api = Yii::$app->novaposhta;
        return $this->render('view',['api'=>$api]);
    }
}
