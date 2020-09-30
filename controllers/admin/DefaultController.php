<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\engine\CMS;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use panix\mod\pages\models\Pages;
use panix\mod\pages\models\PagesSearch;
use panix\engine\controllers\AdminController;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;


class DefaultController extends AdminController
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
        $this->pageName = Yii::t('novaposhta/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('novaposhta/default', 'CREATE_BTN'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->view->params['breadcrumbs'] = [
            $this->pageName
        ];

        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
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
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $result = [];
        $result['success'] = false;
        $isNew = $model->isNewRecord;
        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            //if (Yii::$app->request->isAjax) {
            //    Yii::$app->response->format = Response::FORMAT_JSON;
            //    return ActiveForm::validate($model);
            //}

            if ($model->validate()) {
                $model->save();
                $json['success'] = false;
                if (Yii::$app->request->isAjax && Yii::$app->request->post('ajax')) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $json['success'] = true;
                    $json['message'] = 'Saved.';
                    return $json;
                }

                return $this->redirectPage($isNew, $post);
            } else {
                // print_r($model->getErrors());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionGetWarehouses($city_id)
    {
        $data = Warehouses::getList($city_id);
        return $this->asJson($data);
    }
}
