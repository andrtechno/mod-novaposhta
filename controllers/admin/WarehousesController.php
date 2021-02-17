<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\mod\novaposhta\models\search\WarehousesSearch;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use panix\engine\controllers\AdminController;


class WarehousesController extends AdminController
{

    public $icon = 'location';

    public function actionIndex()
    {
        $api = Yii::$app->novaposhta;
        $this->pageName = Yii::t('novaposhta/default', 'WAREHOUSES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
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
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'WAREHOUSES'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $api = Yii::$app->novaposhta;
        return $this->render('view', ['model' => $model, 'api' => $api]);
    }


    /**
     * @param $id int City Id
     * @return \yii\web\Response JSON result
     */
    public function actionByCity($id)
    {
        $model = Warehouses::find()->where(['CityRef' => $id])->orderBy(['Number' => SORT_ASC])->all();
        $result = [];
        if ($model) {
            $result['total'] = count($model);
            foreach ($model as $item) {
                $result['items'][$item->Ref] = $item->getDescription();
            }
        }
        return $this->asJson($result);
    }
}
