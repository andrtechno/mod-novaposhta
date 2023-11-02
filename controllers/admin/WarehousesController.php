<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\engine\controllers\AdminController;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;


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

        /*$searchModel = new WarehousesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $this->buttons[] = [
            'label' => Yii::t('novaposhta/admin', 'Add warehouses'),
            'url' => ['add'],
            'icon' => 'add',
            'options' => ['class' => 'btn btn-success']
        ];*/

        $currentPage = Yii::$app->request->get('page', 1);
        $data = [];
        $np = Yii::$app->novaposhta->model('Address')->method('getWarehouses');
        $result = $np->params(['Limit' => 50, 'Page' => $currentPage])->execute();
        if ($result['success']) {

            //FAKE items for pagination
            $keys = array_keys($result['data'][0]);
            $key_list = [];

            foreach ($keys as $key) {
                if (in_array($key, ['Reception', 'Schedule', 'Delivery'])) {
                    $key_list[$key] = [];
                } else {
                    $key_list[$key] = $key;
                }
            }
            //beginning add
            for ($i = 1; $i <= 50 * ($currentPage - 1); $i++) {
                array_unshift($result['data'], $key_list);
            }
            //end add
            for ($i = 1; $i <= ($result['info']['totalCount'] - 50 * $currentPage - 1); $i++) {
                array_push($result['data'], $key_list);
            }
            //END FAKE


            $dataProvider = new ArrayDataProvider([
                'allModels' => $result['data'],
                'pagination' => [
                    'pageSize' => 50,
                ],
                'sort' => [
                    'attributes' => ['id', 'name'],
                ],
            ]);
        }


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            //'searchModel' => $searchModel,
        ]);
    }


    public function actionView($number, $city)
    {
        $api = Yii::$app->novaposhta;
        $np = $api->model('Address')->method('getWarehouses');
        $result = $np->params(['WarehouseId' => $number, 'CityRef' => $city])->execute();
        if (!$result['success']) {
            return $this->error404('Error!');
        }
        $data = $result['data'][0];
        // print_r($result);
        // die;

        $model = Warehouses::findOne($number);
        $this->pageName = (Yii::$app->language == 'ru') ? $data['DescriptionRu'] : $data['Description'];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'WAREHOUSES'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;

        return $this->render('view', ['data' => $data, 'api' => $api]);
    }

}
