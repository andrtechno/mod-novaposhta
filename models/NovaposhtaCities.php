<?php

namespace panix\mod\novaposhta\models;

use panix\mod\sitemap\behaviors\SitemapBehavior;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class NovaposhtaCities extends ActiveRecord
{

    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';

    public static function find2()
    {
        return new NewsQuery(get_called_class());
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
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_description', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['name', 'slug'], 'trim'],
            ['slug', '\panix\engine\validators\UrlValidator', 'attributeCompare' => 'name'],
            ['slug', 'match',
                'pattern' => '/^([a-z0-9-])+$/i',
                'message' => Yii::t('app/default', 'PATTERN_URL')
            ],
            [['updated_at', 'created_at'], 'safe'],


            [['short_description', 'image'], 'default'],
        ];
    }

    public function getUrl()
    {
        return ['/news/default/view', 'slug' => $this->slug];
    }

    public function displayDescription($attribute='full_description')
    {
        if (Yii::$app->user->can('admin')) {
            \panix\ext\tinymce\TinyMceInline::widget();
        }
        return (Yii::$app->user->can('admin')) ? $this->isText('full_description') : $this->pageBreak('full_description');
    }

    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    public function behaviors()
    {
        $b = [];
        if (Yii::$app->getModule('seo'))
            $b['seo'] = [
                'class' => '\panix\mod\seo\components\SeoBehavior',
                'url' => $this->getUrl()
            ];

        if (Yii::$app->getModule('sitemap')) {
            $b['sitemap'] = [
                'class' => SitemapBehavior::class,
                //'batchSize' => 100,
                'scope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select(['slug', 'updated_at']);
                    $model->where(['switch' => 1]);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => $model->getUrl(),
                        'lastmod' => $model->updated_at,
                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.1
                    ];
                }
            ];
        }
        if (Yii::$app->hasModule('comments')) {
            $b['commentBehavior'] = [
                'class' => 'panix\mod\comments\components\CommentBehavior',
                'owner_title' => 'name',

            ];
        }


        $b['uploadFile'] = [
            'class' => 'panix\engine\behaviors\UploadFileBehavior',
            'files' => [
                'image' => '@uploads/news',
            ],
            'options' => [
                'watermark' => false
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($b, parent::behaviors());
    }

}
