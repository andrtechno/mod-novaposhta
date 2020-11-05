<?php

namespace panix\mod\novaposhta\models\search;

use panix\mod\novaposhta\models\Cities;
use Yii;
use yii\base\Model;
use panix\engine\data\ActiveDataProvider;

/**
 * CitiesSearch represents the model behind the search form about `panix\mod\novaposhta\models\Warehouses`.
 */
class CitiesSearch extends Cities
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'integer'],
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
        $query = Cities::find()->orderBy(['Description'=>SORT_ASC]);

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

        if(Yii::$app->language == 'ru'){
            $query->andFilterWhere(['like', 'DescriptionRu', $this->Description]);
            $query->andFilterWhere(['like', 'AreaDescriptionRu', $this->AreaDescriptionRu]);
            $query->andFilterWhere(['like', 'SettlementTypeDescriptionRu', $this->SettlementTypeDescriptionRu]);
        }else{
            $query->andFilterWhere(['like', 'Description', $this->Description]);
            $query->andFilterWhere(['like', 'AreaDescription', $this->AreaDescription]);
            $query->andFilterWhere(['like', 'SettlementTypeDescription', $this->SettlementTypeDescription]);
        }


        return $dataProvider;
    }

}
