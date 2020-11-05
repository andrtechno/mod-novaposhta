<?php

namespace panix\mod\novaposhta\models;

use panix\mod\novaposhta\models\query\CommonQuery;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "novaposhta_cities".
 *
 * @property integer $Ref
 * @property string $Description
 * @property string $DescriptionRu
 * @property string $AreaDescription
 * @property string $AreaDescriptionRu
 * @property string $SettlementTypeDescription
 * @property string $SettlementTypeDescriptionRu
 * @property integer $created_at
 * @property integer $updated_at
 * @property Warehouses[] $warehouses
 */
class Cities extends ActiveRecord
{

    const route = '/admin/novaposhta/default';
    const MODULE_ID = 'novaposhta';

    public static function find()
    {
        return new CommonQuery(get_called_class());
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

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }

    public function getAreaDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->AreaDescriptionRu : $this->AreaDescription;
    }

    public function getSettlementTypeDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->SettlementTypeDescriptionRu : $this->SettlementTypeDescription;
    }

    public function getWarehouses()
    {
        return $this->hasMany(Warehouses::class, ['CityRef' => 'Ref']);
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
