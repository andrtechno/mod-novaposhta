<?php

namespace panix\mod\novaposhta\models\search;

use panix\mod\novaposhta\models\Cities;
use panix\mod\novaposhta\models\ExpressInvoice;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use yii\base\Model;
use panix\engine\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class ExpressInvoiceSearch extends ExpressInvoice
{
    public $RedeliveryMoney;
    public $DateTimeFrom;
    public $DateTimeTo;

    private $_filtered = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['RedeliveryMoney'], 'boolean'],
            [['DateTimeTo', 'DateTimeFrom'], 'safe'],
            [['DateTimeFrom', 'DateTimeTo'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        if ($this->load($params) && $this->validate()) {
            $this->_filtered = true;
        }

        $filter['GetFullList'] = 1;
        if ($this->RedeliveryMoney) {
            $filter['RedeliveryMoney'] = 1;
        }
        if ($this->DateTimeFrom && $this->DateTimeTo) {
            $filter['DateTimeFrom'] = "10.02.2021";
            $filter['DateTimeTo'] = $this->DateTimeTo;
        }
        // 'DateTime'=>'17.02.2021',


        $response = Yii::$app->novaposhta->getDocumentList($filter);
        $dataResult = [];
        $serviceTypes = ServiceTypes::getList();
        if ($response['success']) {
            foreach ($response['data'] as $data) {
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
        }

        $dataProvider = new ArrayDataProvider([
            //'allModels' => $this->getData(),
            'allModels' => $dataResult,
            'pagination' => [
                'pageSize' => 100,
            ],
            //  'sort' => $sort,
        ]);

        return $dataProvider;
    }

    protected function getData()
    {
        $data = [
            ['name' => 'Paul', 'Ref' => 'abc'],
            ['name' => 'John', 'Ref' => 'ade'],
            ['name' => 'Rick', 'Ref' => 'dbn'],
        ];


        if ($this->_filtered) {
            $data = array_filter($data, function ($value) {
                $conditions = [true];
                if (!empty($this->name)) {
                    $conditions[] = strpos($value['name'], $this->name) !== false;
                }
                if (!empty($this->code)) {
                    $conditions[] = strpos($value['Ref'], $this->code) !== false;
                }
                return array_product($conditions);
            });
        }

        return $data;
    }
}
