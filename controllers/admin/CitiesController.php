<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\engine\CMS;
use panix\mod\novaposhta\components\QueueCities;
use panix\mod\novaposhta\models\search\CitiesSearch;
use panix\mod\novaposhta\models\Cities;
use Yii;
use panix\engine\controllers\AdminController;


class CitiesController extends AdminController
{
    public $icon = 'location-map';

    public function actionIndex()
    {


        /* @var $api \panix\mod\novaposhta\components\Novaposhta */
        $api = Yii::$app->novaposhta;


        $limit = 250;
        $getTotal = $api->getCities(1, 1);
        //CMS::dump($getTotal);die;
//echo $getTotal['info']['totalCount'];
        //echo '<br>';
        //echo '<br>';
        $total_pages = ceil($getTotal['info']['totalCount'] / $limit);

        for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
            /*$cities = Yii::$app->novaposhta->getCities($page_number, $limit);
            if ($cities['success']) {
                Yii::$app->queue->push(new QueueCities([
                    'data' => $cities['data'],
                ]));
            }*/
           // echo $page_number;
           // echo '<br>';
        }




        $this->pageName = Yii::t('novaposhta/default', 'CITIES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
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
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $api = Yii::$app->novaposhta;
        return $this->render('view', ['model' => $model, 'api' => $api]);
    }
}
