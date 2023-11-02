<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\cart\models\Order;
use panix\mod\cart\widgets\delivery\novaposhta\api\NovaPoshtaApi;
use panix\mod\discounts\models\DiscountSearch;
use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\Cities;
use panix\mod\novaposhta\models\Errors;
use panix\mod\novaposhta\models\ExpressInvoice;
use panix\mod\novaposhta\models\ExpressInvoiceForm;
use panix\mod\novaposhta\models\search\ExpressInvoiceSearch;
use panix\mod\novaposhta\models\search\ExpressInvoiceSearch2;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;


class ExpressInvoiceController extends AdminController
{
    public $icon = 'books';

    public function actions()
    {
        return [
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => ExpressInvoice::class,
            ],
        ];
    }
    public function actionIndex()
    {
        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;
        $this->pageName = Yii::t('novaposhta/default', 'EXPRESS_WAYBILL');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('novaposhta/default', 'CREATE_EXPRESS_WAYBILL'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;


        $searchModel = new ExpressInvoiceSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());


        // CMS::dump($data);die;
        /*$dataResult = [];
        $serviceTypes = ServiceTypes::getList();
        if ($data['success']) {
            foreach ($data['data'] as $data) {

                $dataResult[] = [
                    'Ref' => $data['Ref'],
                    'RecipientContactPerson' => $data['RecipientContactPerson'],
                    'RecipientContactPhone' => $data['RecipientContactPhone'],
                    'ContactSender' => $data['ContactSender'],
                    'ContactRecipient' => $data['ContactRecipient'],
                    'RecipientsPhone' => $data['RecipientsPhone'],
                    'StateName' => $data['StateName'],
                    'IntDocNumber' => $data['IntDocNumber'],
                    'DateTime' => $data['DateTime'],
                    'CostOnSite' => $data['CostOnSite'],
                    'Description' => $data['Description'],
                    'CitySender' => Cities::findOne(['Ref' => $data['CitySender']])->getDescription(),
                    'SenderAddress' => Warehouses::findOne(['Ref' => $data['SenderAddress']])->getDescription(),
                    'CityRecipient' => Cities::findOne(['Ref' => $data['CityRecipient']])->getDescription(),
                    'RecipientAddress' => Warehouses::findOne(['Ref' => $data['RecipientAddress']])->getDescription(),
                    'ServiceType' => $serviceTypes[$data['ServiceType']],
                ];
            }
        }*/



        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'api' => $api,
            'searchModel'=>$searchModel
        ]);
    }


    public function actionCreate()
    {

        $api = Yii::$app->novaposhta;
        $model = new ExpressInvoice();
        $model->scenario = 'create';

        $this->pageName = html_entity_decode(Yii::t('novaposhta/default', 'CREATE_EXPRESS_WAYBILL'));
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'EXPRESS_WAYBILL'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $isNew = $model->isNewRecord;
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            print_r($post);die;
            $model->order_id = Yii::$app->request->get('order_id');
            //  print_r($model->attributes);die;
            if ($model->validate()) {
                $model->save();
               // CMS::dump($model->attributes);
               // die;
                if($model->_errors){
                    foreach ($model->_errors as $error) {
                        Yii::$app->session->addFlash('error', $error);
                    }
                }else{
                    if($model->_warnings){
                        foreach ($model->_warnings as $wrn) {
                            Yii::$app->session->addFlash('warning', $wrn);
                        }
                    }
                    Yii::$app->session->addFlash('success', Yii::t('novaposhta/default', ($isNew)?'SUCCESS_CREATE_EXPRESS':'SUCCESS_UPDATE_EXPRESS', $model->IntDocNumber));
                    return $this->redirect(['index']);
                }

            } else {
                //CMS::dump($model->errors);die;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'api' => $api,
            //'order'=>$order
        ]);
    }




    public function actionUpdate($id = false)
    {
        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;
        $model = ExpressInvoice::findOne(['Ref' => $id]);

       // $data = $api->getDocument($id);
       // if ($data['success']) {
          //  $result = $data['data'][0];
           // CMS::dump($result);die;
            //$this->pageName = 'Редактирование ' . $result['Number'];
            // CMS::dump($result);
            //  die;
//$test = $api->getCounterpartyContactPersons($result['RecipientRef']);
            //  CMS::dump($test);
//echo $result['DateTime'];
//echo '<br>';
          //  $model->Description = $result['Description'];
           // $model->PayerType = $result['PayerTypeRef'];
           // $model->PaymentMethod = $result['PaymentMethodRef'];

            // $date = new \DateTime($result['DateTime'], new \DateTimeZone('Europe/Kiev'));
            // $model->DateTime = $date->format('d.m.Y');
//echo $model->DateTime;die;

           /* $model->DateTime = $result['DateTime'];
            $model->CargoType = $result['CargoTypeRef'];
            $model->VolumeGeneral = $result['VolumeGeneral'];
            $model->Weight = $result['Weight'];
            $model->ServiceType = $result['ServiceTypeRef'];
            $model->SeatsAmount = $result['SeatsAmount'];
            $model->Cost = $result['Cost'];
            $model->CitySender = $result['CitySenderRef'];
            $model->Sender = $result['SenderRef'];
            $model->SenderAddress = $result['SenderAddressRef'];
            $model->ContactSender = $result['ContactSenderRef'];
            $model->SendersPhone = $result['SendersPhone'];
            $model->CityRecipient = $result['CityRecipientRef'];
            $model->RecipientRef = $result['RecipientRef'];
            $model->RecipientAddress = $result['RecipientAddressRef'];
            $model->ContactRecipient = $result['ContactRecipientRef'];
            $model->RecipientsPhone = $result['RecipientsPhone'];
            if (isset($result['OptionsSeat']))
                $model->OptionsSeat = $result['OptionsSeat'];
            if (isset($result['BackwardDeliveryData']))
                $model->BackwardDeliveryData = $result['BackwardDeliveryData'];
        }*/


        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['/novaposhta/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('novaposhta/default', 'EXPRESS_WAYBILL'),
            'url' => ['index']
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;
        $post = Yii::$app->request->post();
        $model->scenario = 'update';
       // \panix\engine\CMS::dump($model->BackwardDeliveryData);die;
        if ($model->load($post)) {


            if ($model->validate()) {

                $model->save();
                if($model->_errors){
                    foreach ($model->_errors as $error) {
                        Yii::$app->session->addFlash('error', $error);
                    }
                }else{
                    if($model->_warnings){
                        foreach ($model->_warnings as $wrn) {
                            Yii::$app->session->addFlash('warning', $wrn);
                        }
                    }
                    Yii::$app->session->addFlash('success', Yii::t('novaposhta/default', 'SUCCESS_UPDATE_EXPRESS', $model->IntDocNumber));
                    return $this->redirect(['index']);
                }

               //  CMS::dump($model->_errors);die;

               /* if ($response['success']) {
                    if ($model->order_id) {
                        $order = Order::findOne($model->order_id);
                        if ($order) {

                            $order->ttn = $response['data'][0]['IntDocNumber'];
                            $order->delivery_price = $response['data'][0]['CostOnSite'];
                            $order->save(false);
                        }
                    }

                    Yii::$app->session->addFlash('success', Yii::t('novaposhta/default', 'SUCCESS_UPDATE_EXPRESS', $response['data'][0]['IntDocNumber']));

                    if (isset($response['warnings'])) {
                        foreach ($response['warnings'] as $warn) {
                            Yii::$app->session->addFlash('warning', $warn);
                        }
                    }

                    return $this->redirect(['index']);
                } else {
                    foreach ($response['errors'] as $key => $error) {
                        Yii::$app->session->addFlash('error', $response['errorCodes'][$key] . ' - ' . $error);
                    }
                }*/

            } else {
                CMS::dump($model->errors);
                die;
            }
        }


        return $this->render('update', [
            'model' => $model,
            'api' => $api
        ]);
    }

    public function actionView($id)
    {
        $api = Yii::$app->novaposhta;
        $data = $api->getDocument($id);
        $result = false;
        if ($data['success']) {


            /* $this->buttons = [
                 [
                     'icon' => 'print',
                     'label' => Yii::t('app/default', 'PRINT') . ' PDF',
                     'url' => 'https://my.novaposhta.ua/orders/printDocument/orders[]/' . $id . '/type/pdf/apiKey/' . Yii::$app->settings->get('novaposhta', 'api_key'),
                     'options' => ['class' => 'btn btn-outline-secondary', 'target' => '_blank']
                 ],
                 [
                     'icon' => 'print',
                     'label' => Yii::t('app/default', 'PRINT') . ' HTML',
                     'url' => 'https://my.novaposhta.ua/orders/printDocument/orders[]/' . $id . '/type/html/apiKey/' . Yii::$app->settings->get('novaposhta', 'api_key'),
                     'options' => ['class' => 'btn btn-outline-secondary', 'target' => '_blank']
                 ]
             ];*/


            $result = $data['data'][0];
            $this->pageName = 'ТТН: ' . $result['IntDocNumber'];
            $this->view->params['breadcrumbs'][] = [
                'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
                'url' => ['/novaposhta/admin/default/index']
            ];
            $this->view->params['breadcrumbs'][] = [
                'label' => Yii::t('novaposhta/default', 'EXPRESS_WAYBILL'),
                'url' => ['index']
            ];
            $this->view->params['breadcrumbs'][] = $this->pageName;


        } else {

        }

        return $this->render('view', ['api' => $api, 'result' => $result]);
    }

    public function actionDelete($id)
    {
        /** @var Novaposhta $api */
        $api = Yii::$app->novaposhta;

        $response = $api->model('InternetDocument')->delete([
            'DocumentRefs' => [$id]
        ]);

        if ($response['success']) {
            Yii::$app->session->setFlash('success', 'Экспресс-накладная успешно уладена');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка удаление Экспресс-накладной');
        }
        return $this->redirect(['index']);

    }

}
