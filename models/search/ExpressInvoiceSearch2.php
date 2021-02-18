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

class ExpressInvoiceSearch2 extends ExpressInvoice
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['RedeliveryMoney'], 'boolean'],
            //[['DateTimeTo', 'DateTimeFrom'], 'safe'],
            [['CostOnSite'], 'string'],
            [['IntDocNumber'], 'integer'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ExpressInvoice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['Ref' => $this->Ref]);



        $query->andFilterWhere(['like', 'IntDocNumber', $this->IntDocNumber]);
        $query->andFilterWhere(['like', 'CostOnSite', $this->CostOnSite]);


        return $dataProvider;
    }

}
