<?php

namespace panix\mod\novaposhta\controllers\admin;

use panix\engine\CMS;
use panix\engine\Html;
use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\ExpressInvoice;
use panix\mod\novaposhta\models\ExpressInvoiceForm;
use panix\mod\novaposhta\models\ServiceTypes;
use Yii;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;


class ExpressInvoiceController extends AdminController
{


    public function actionIndex()
    {
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
        $this->breadcrumbs[] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;


        $data = $api->getDocumentList();
        $dataResult = [];
        $serviceTypes = ServiceTypes::getList();
        if ($data['success']) {
            foreach ($data['data'] as $data) {
                // CMS::dump($data);die;
                $dataResult[] = [
                    'Ref' => $data['Ref'],
                    'ContactSender' => $data['ContactSender'],
                    'ContactRecipient' => $data['ContactRecipient'],
                    'RecipientsPhone' => $data['RecipientsPhone'],
                    'StateName' => $data['StateName'],
                    'IntDocNumber' => $data['IntDocNumber'],
                    'ServiceType' => $serviceTypes[$data['ServiceType']],
                ];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $dataResult,
            'pagination' => [
                'pageSize' => 100,
            ],
            //  'sort' => $sort,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'api' => $api,
        ]);
    }

    public function actionCreate()
    {

        $api = Yii::$app->novaposhta;
        $model = new ExpressInvoice();


        $this->pageName = html_entity_decode(Yii::t('novaposhta/default', 'CREATE_EXPRESS_WAYBILL'));
        $this->breadcrumbs[] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('novaposhta/default', 'EXPRESS_WAYBILL'),
            'url' => ['express-invoice']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {

                $result = $model->save();
                if ($result) {
                    return $this->redirect(['/admin/novaposhta/express-invoice']);
                } else {
                    CMS::dump($result);
                    die('err');
                }

            } else {
                print_r($model->getErrors());
            }
        }

        return $this->render('create', [
            'model' => $model,
            'api' => $api,
            //'order'=>$order
        ]);
    }

    public function actionCreateOld()
    {

        $api = Yii::$app->novaposhta;
        $model = new ExpressInvoiceForm();

        $model->DateTime = date('d.m.Y');
        $model->SeatsAmount = 1;
        $model->Weight = 1;
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {

                $result = $model->save();
                if ($result) {
                    return $this->redirect(['/admin/novaposhta/express-invoice']);
                } else {
                    CMS::dump($result);
                    die('err');
                }

            } else {
                print_r($model->getErrors());
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
        $api = Yii::$app->novaposhta;
        $model = new ExpressInvoiceForm();
        $data = $api->getDocument($id);
        if ($data['success']) {
            $result = $data['data'][0];
            $model->Description = $result['Description'];
            $model->PayerType = $result['PayerType'];
            $model->PaymentMethod = $result['PaymentMethod'];
            $model->DateTime = $result['DateTime'];
            $model->CargoType = $result['CargoType'];
            $model->VolumeGeneral = $result['VolumeGeneral'];
            $model->Weight = $result['Weight'];
            $model->ServiceType = $result['ServiceType'];
            $model->SeatsAmount = $result['SeatsAmount'];
            $model->Cost = $result['Cost'];
            $model->CitySender = $result['CitySender'];
            $model->Sender = $result['Sender'];
            $model->SenderAddress = $result['SenderAddress'];
            $model->ContactSender = $result['ContactSender'];
            $model->SendersPhone = $result['SendersPhone'];
            $model->CityRecipient = $result['CityRecipient'];
            $model->Recipient = $result['Recipient'];
            $model->RecipientAddress = $result['RecipientAddress'];
            $model->ContactRecipient = $result['ContactRecipient'];
            $model->RecipientsPhone = $result['RecipientsPhone'];
        }

        $this->pageName = Yii::t('novaposhta/default', 'CREATE_BTN');

        $this->breadcrumbs[] = [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {
                $response = $api->model('InternetDocument')->update([
                    'Ref' => $id,
                    'Description' => $model->Description,
                    'PayerType' => $model->PayerType,
                    'PaymentMethod' => $model->PaymentMethod,
                    'DateTime' => $model->DateTime,
                    'CargoType' => $model->CargoType,
                    'VolumeGeneral' => $model->VolumeGeneral,
                    'Weight' => $model->Weight,
                    'ServiceType' => $model->ServiceType,
                    'SeatsAmount' => $model->SeatsAmount,
                    'Cost' => $model->Cost,
                    'CitySender' => $model->CitySender,
                    'Sender' => $model->Sender,
                    'SenderAddress' => $model->SenderAddress,
                    'ContactSender' => $model->ContactSender,
                    'SendersPhone' => $model->SendersPhone,
                    'CityRecipient' => $model->CityRecipient,
                    'Recipient' => $model->Recipient,
                    'RecipientAddress' => $model->RecipientAddress,
                    'ContactRecipient' => $model->ContactRecipient,
                    'RecipientsPhone' => $model->RecipientsPhone,
                ]);
                if ($response['success']) {
                    CMS::dump($response);
                    die('ok');
                }
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


            $this->buttons = [
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
            ];


            $result = $data['data'][0];
            $this->pageName = 'ТТН: ' . $result['IntDocNumber'];
            $this->breadcrumbs[] = [
                'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
                'url' => ['index']
            ];
            $this->breadcrumbs[] = $this->pageName;


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

        //  CMS::dump($response);
        //  die;
    }

}
