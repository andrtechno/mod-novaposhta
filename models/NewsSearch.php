<?php

namespace panix\mod\news\models;

use Yii;
use yii\base\Model;
use panix\engine\data\ActiveDataProvider;
use panix\mod\news\models\News;
use panix\mod\news\models\NewsTranslate;

/**
 * NewsSearch represents the model behind the search form about `panix\mod\news\models\News`.
 */
class NewsSearch extends News
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'views'], 'integer'],
            [['name', 'slug', 'created_at'], 'safe'],
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
        $query = News::find()->translate();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => self::getSort(),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'translate.name', $this->name]);
        $query->andFilterWhere(['like', 'DATE(created_at)', $this->created_at]);
        $query->andFilterWhere(['like', 'DATE(created_at)', $this->created_at]);
        $query->andFilterWhere(['like', 'views', $this->views]);

        return $dataProvider;
    }

    public static function getSort()
    {
        $sort = new \yii\data\Sort([
            'attributes' => [
                'created_at',
                'updated_at',
                'views',
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
            ],
        ]);
        return $sort;
    }
}
