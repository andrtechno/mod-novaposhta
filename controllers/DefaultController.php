<?php

namespace panix\mod\novaposhta\controllers;

use Yii;
use panix\engine\controllers\WebController;

class DefaultController extends WebController
{

    public function actionView($slug)
    {
        $this->view->title = $this->pageName;
        return $this->render('view', []);
    }

}
