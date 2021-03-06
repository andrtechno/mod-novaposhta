<?php

namespace panix\mod\novaposhta\models\search;

use panix\engine\CMS;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use yii\base\Model;
use panix\engine\data\ActiveDataProvider;

/**
 * WarehousesSearch represents the model behind the search form about `panix\mod\novaposhta\models\Warehouses`.
 */
class WarehousesSearch extends Warehouses
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Ref','CityRef'], 'string'],
            [['Description'], 'safe'],
            [['Description'], 'string'],
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
        $query = Warehouses::find()->orderBy(['Number'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>100]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['Ref' => $this->Ref]);
        $query->andFilterWhere(['CityRef' => $this->CityRef]);
        $query->andFilterWhere(['like', 'Description', $this->Description]);


        return $dataProvider;
    }

}
