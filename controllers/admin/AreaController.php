<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\mod\novaposhta\models\search\AreaSearch;
use panix\mod\novaposhta\models\Area;
use Yii;
use panix\engine\controllers\AdminController;


class AreaController extends AdminController
{
    public $icon = 'location-map';

    public function actionIndex()
    {
        $api = Yii::$app->novaposhta;
        $this->pageName = Yii::t('novaposhta/default', 'AREAS');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $searchModel = new AreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        if (!$dataProvider->totalCount) {
            $this->buttons[] = [
                'label' => Yii::t('novaposhta/admin', 'Add areas'),
                'url' => ['add'],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-success']
            ];
        }

        $this->view->params['breadcrumbs'][] = $this->pageName;


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionView($id)
    {
        $model = Area::findOne($id);
        $this->pageName = $model->getDescription();
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => '#'
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'AREAS'),
            'url' => ['/novaposhta/admin/area/index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $api = Yii::$app->novaposhta;
        return $this->render('view', ['model' => $model, 'api' => $api]);
    }

    public function actionAdd()
    {
        Area::getDb()->createCommand()->truncateTable(Area::tableName())->execute();

        $result = Yii::$app->novaposhta->model('Address')->method('getAreas')->execute();

        if ($result['success']) {
            $list = [];
            foreach ($result['data'] as $key => $d) {
                $list[] = array_values($d);
            }
            Area::getDb()->createCommand()->batchInsert(Area::tableName(), array_keys($result['data'][0]), $list)->execute();
        }
        Yii::$app->session->addFlash('success', 'Areas created!');
        return $this->redirect(['index']);
    }
}
