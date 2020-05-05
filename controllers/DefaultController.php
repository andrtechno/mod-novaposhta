<?php

namespace panix\mod\novaposhta\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\pages\models\Pages;
use yii\helpers\ArrayHelper;
use yii\web\View;

class DefaultController extends WebController
{
    public function behaviors1()
    {
        $behaviors[] = [
            'class' => 'yii\filters\PageCache',
            'only' => ['view'],
            'duration' => 86400 * 30,
            'variations' => [
                //Yii::$app->language,
                Yii::$app->request->get('slug')
            ],
            'dependency' => [
                'class' => 'yii\caching\DbDependency',
                'sql' => 'SELECT MAX(updated_at) FROM ' . Pages::tableName(),
            ]
        ];
        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }

    public function actionView($slug)
    {
        $layouts = [
            "@theme/modules/pages/views/default/html",
            "@pages/views/default/html",
        ];

        foreach ($layouts as $layout) {
            if (file_exists(Yii::getAlias($layout) . DIRECTORY_SEPARATOR . $slug . '.' . $this->view->defaultExtension)) {
                return $this->render($layout . '/' . $slug, []);
            }
        }

        $this->dataModel = Pages::find()
            ->where(['slug' => $slug])
            ->published()
           // ->cache(3200, new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM ' . Pages::tableName()]))
            ->one();

        if (!$this->dataModel) {
            $this->error404();
        }
        $this->pageName = $this->dataModel->name;
        $this->breadcrumbs = [$this->pageName];

        $this->view->setModel($this->dataModel);



        $this->view->title = $this->pageName;
        return $this->render('view', ['model' => $this->dataModel]);
    }

}
