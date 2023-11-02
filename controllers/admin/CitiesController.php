<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\engine\CMS;
use panix\mod\novaposhta\components\QueueCities;
use panix\mod\novaposhta\models\search\CitiesSearch;
use panix\mod\novaposhta\models\Cities;
use Yii;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;


class CitiesController extends AdminController
{
    public $icon = 'location-map';

    public function actionIndex()
    {
        /* @var $api \panix\mod\novaposhta\components\Novaposhta */
        $api = Yii::$app->novaposhta;


        $currentPage = Yii::$app->request->get('page', 1);
        $data = [];
        $result = $api->getCities($currentPage, 50);

        if ($result['success']) {

            //FAKE items for pagination
            $keys = array_keys($result['data'][0]);
            $key_list = [];

            foreach ($keys as $key) {
                //if (in_array($key, ['Delivery'])) {
                //    $key_list[$key] = [];
                //} else {
                $key_list[$key] = $key;
                // }
            }
            //beginning add
            for ($b = 1; $b <= 50 * ($currentPage - 1); $b++) {
                array_unshift($result['data'], $key_list);
            }
            //echo ($result['info']['totalCount'] - 50 * $currentPage);die;
            //end add
            for ($e = 0; $e <= ($result['info']['totalCount'] - 50 * $currentPage - 1); $e++) {
                array_push($result['data'], $key_list);
            }
            //END FAKE

        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $result['data'],
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        $areas = Yii::$app->novaposhta->getAreas();
        $areas = \yii\helpers\ArrayHelper::map($areas['data'], 'Ref', function ($res) {
            return (Yii::$app->language == 'ru') ? $res['DescriptionRu'] : $res['Description'];
        });


        $this->pageName = Yii::t('novaposhta/default', 'CITIES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $this->buttons[] = [
            'label' => Yii::t('novaposhta/default', 'Очистить кэш'),
            'url' => ['clear'],
            'icon' => 'trashcan',
            'options' => ['class' => 'btn btn-warning']
        ];
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'areas' => $areas,
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

    public function actionClear()
    {
        Yii::$app->cache->delete('np-cities');
        Yii::$app->session->addFlash('success', 'Cleat list areas success');
        return $this->redirect(['index']);
    }
}
