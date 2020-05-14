<?php

namespace panix\mod\novaposhta\models;

use panix\mod\novaposhta\models\query\CitiesQuery;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "novaposhta".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class Cities extends ActiveRecord
{

    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';

    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }

    public function getGridColumns()
    {
        return [
            'id' => [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'name',
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'views',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new NewsSearch(),
                    'attribute' => 'created_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new NewsSearch(),
                    'attribute' => 'updated_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d D Y H:i:s');
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
                [
                    'class' => \panix\engine\grid\sortable\Column::class,
                    'url' => ['/admin/news/default/sortable']
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta_cities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description', 'DescriptionRu'], 'required'],
            [['DescriptionRu'], 'string', 'max' => 255],
            [['DescriptionRu'], 'string'],
            [['DescriptionRu'], 'trim'],

            [['updated_at', 'created_at'], 'safe'],


            [['DescriptionRu', 'Description'], 'default'],
        ];
    }


    public static function getList($wheres = [])
    {
        $result = [];
        $query = self::find();
        if ($wheres) {
            $query->where($wheres);
        }
        $list = $query->asArray()->all();
        if ($list) {
            foreach ($list as $item) {
                $result[$item['Ref']] = $item['DescriptionRu'];
            }
        } else {
            $list = Yii::$app->novaposhta->getCities();
            if ($list['success']) {
                foreach ($list['data'] as $item) {
                    $result[$item['Ref']] = $item['DescriptionRu'];
                }
            }
        }


        return $result;
    }

}
