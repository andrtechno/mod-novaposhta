<?php

namespace panix\mod\novaposhta\controllers\admin;

use Yii;
use panix\mod\pages\models\Pages;
use panix\mod\pages\models\PagesSearch;
use panix\engine\controllers\AdminController;
use yii\web\Response;
use yii\widgets\ActiveForm;


class ExpressInvoiceController extends AdminController
{

    public function actions()
    {
        return [
            'sortable' => [
                'class' => 'panix\engine\grid\sortable\Action',
                'modelClass' => Pages::class,
            ],
            'switch' => [
                'class' => 'panix\engine\actions\SwitchAction',
                'modelClass' => Pages::class,
            ],
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => Pages::class,
            ],
        ];
    }

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

        return $this->render('index', [

            'api' => $api,
        ]);
    }

    public function actionUpdate($id = false)
    {

        $model = Pages::findModel($id);
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
        ]);
    }
    public function actionView(){
        $api = Yii::$app->novaposhta;
        return $this->render('view',['api'=>$api]);
    }
}
