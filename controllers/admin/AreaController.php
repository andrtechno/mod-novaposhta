<?php

namespace panix\mod\novaposhta\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;


class AreaController extends AdminController
{
    public $icon = 'location-map';

    public function actionIndex()
    {
        /* @var $api \panix\mod\novaposhta\components\Novaposhta */
        $api = Yii::$app->novaposhta;

        $result = $api->getAreas();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $result['data'],
            'pagination' => ['pageSize' => 100]
        ]);


        $this->pageName = Yii::t('novaposhta/default', 'AREAS');
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
        ]);
    }

    public function actionClear()
    {
        Yii::$app->cache->delete('np-areas');
        Yii::$app->session->addFlash('success', 'Cleat list areas success');
        return $this->redirect(['index']);
    }

}
