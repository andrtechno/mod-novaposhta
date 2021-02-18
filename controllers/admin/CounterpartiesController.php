<?php

namespace panix\mod\novaposhta\controllers\admin;

use Yii;
use panix\engine\CMS;
use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\counterparties\Counterparties;
use panix\mod\novaposhta\models\forms\CounterpartyForm;
use panix\engine\controllers\AdminController;
use panix\mod\novaposhta\models\Errors;

class CounterpartiesController extends AdminController
{
    public $icon = 'user-card';

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
        $this->pageName = Yii::t('novaposhta/default', 'COUNTERPARTIES');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('novaposhta/default', 'CREATE_COUNTERPARTY'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        return $this->render('index', [

            'api' => $api,
        ]);
    }

    public function actionUpdate222($id = false)
    {
        $model = Counterparties::findModel($id);
        $api = Yii::$app->novaposhta;
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
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $result = [];
        $isNew = $model->isNewRecord;
        $post = Yii::$app->request->post();


        $types = $api->getTypesOfCounterparties();

        $typesList = [];
        if ($types['success']) {
            foreach ($types['data'] as $data) {
                $typesList[$data['Ref']] = $data['Description'];
            }
        }

        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();

                return $this->redirectPage($isNew, $post);
            } else {
                // print_r($model->getErrors());
            }
        }

        return $this->render('update', [
            'api' => $api,
            'model' => $model,
            'typesList' => $typesList
        ]);
    }

    /**
     * @param string $id GUID
     * @return string
     */
    public function actionView($id)
    {

        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;
        $response = $api->getCounterpartyContactPersons($id);

        $data = [];
        if ($response['success']) {
            $data = $response['data'];
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 100,
            ],
            //  'sort' => $sort,
        ]);
        return $this->render('view', [
            'api' => $api,
            'dataProvider' => $dataProvider,
            'counterpartyRef' => $id
        ]);
    }

    public function actionCreate()
    {

        $this->pageName = Yii::t('novaposhta/default', 'CREATE_COUNTERPARTY');
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => '#'
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'COUNTERPARTIES'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;


        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;
        $model = new CounterpartyForm();
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {
                $result = $api->model('Counterparty')->save(array(
                    'CounterpartyProperty' => $model->CounterpartyProperty,//'Recipient',
                    'CityRef' => $model->CityRef,
                    'CounterpartyType' => $model->CounterpartyType,
                    'FirstName' => $model->FirstName,
                    'MiddleName' => $model->MiddleName,
                    'LastName' => $model->LastName,
                    'Phone' => $model->Phone,
                ));
                if ($result['success']) {
                    Yii::$app->session->setFlash('success', 'Success');
                } else {

                    if (in_array(20000100526, $result['errorCodes'])) { //FirstName
                        $model->addError('FirstName', Errors::run(20000100526));
                    }
                    if (in_array(20000100532, $result['errorCodes'])) { //LastName
                        $model->addError('LastName', Errors::run(20000100532));
                    }
                    if (in_array(20000100552, $result['errorCodes'])) { //Phone
                        $model->addError('Phone', Errors::run(20000100552));
                    }
                    if (in_array(20000100516, $result['errorCodes'])) { //Phone
                        $model->addError('CounterpartyType', Errors::run(20000100516));
                    }
                    if (in_array(20000900772, $result['errorCodes'])) { //Phone
                        $model->addError('CounterpartyProperty', Errors::run(20000900772));
                    }

                    if (in_array(20000900760, $result['errorCodes'])) { //CompanyName
                        $model->addError('CompanyName', Errors::run(20000900760));
                    }
                    if (in_array(20000900766, $result['errorCodes'])) { //LastName
                        $model->addError('LastName', Errors::run(20000900766));
                    }
                    if (in_array(20000900756, $result['errorCodes'])) { //Phone
                        $model->addError('Phone', Errors::run(20000900756));
                    }
                    if (in_array(20000200235, $result['errorCodes'])) { //OwnershipForm
                        $model->addError('OwnershipForm', Errors::run(20000200235));
                    }

                    //   CMS::dump($result);die;


                }

                // CMS::dump($result);die;
            }
        }
        return $this->render('create', [
            'api' => $api,
            'model' => $model,
        ]);
    }

    public function actionUpdate($id, $counterpartyRef)
    {
        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;
        $response = $api->getCounterparties('Recipient', 1, 'Петр');
        CMS::dump($response);
        die;

        $result = $api->model('ContactPerson')->update(array(
            'Ref' => $id,
            'CounterpartyRef' => '273872de-9242-11e6-a54a-005056801333',
            'FirstName' => 'Петр',
            'MiddleName' => 'Сидорович',
            'LastName' => 'Иванов',
            'Phone' => '0501112266',
        ));
        CMS::dump($result);
        die;


        $res = $api->model('ContactPerson')
            ->params([
                'CounterpartyRef' => $id,
                'Phone' => '+380997979789',
            ])
            ->method('update')
            ->execute();

        return $this->render('update', [
            'api' => $api,


        ]);
    }
}
