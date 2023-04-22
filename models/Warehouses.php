<?php

namespace panix\mod\novaposhta\models;


use Yii;
use panix\engine\db\ActiveRecord;
use panix\mod\novaposhta\models\query\CommonQuery;

/**
 * This is the model class for table "novaposhta".
 *
 * @property string $Ref Guid
 * @property string $CityRef Guid
 * @property string $Description
 * @property string $DescriptionRu
 * @property string $ShortAddressRu
 * @property string $ShortAddress
 * @property string $CityDescriptionRu
 * @property string $CityDescription
 * @property string $BicycleParking
 */
class Warehouses extends ActiveRecord
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
        return '{{%novaposhta__warehouses}}';
    }

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }

    public function getShortAddress()
    {
        return (Yii::$app->language == 'ru') ? $this->ShortAddressRu : $this->ShortAddress;
    }

    public function getCityDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->CityDescriptionRu : $this->CityDescription;
    }

    public function getReceptions()
    {
        return json_decode($this->Reception);
    }

    public function getSchedule()
    {
        return json_decode($this->Schedule);
    }

    public function getDelivery()
    {
        return json_decode($this->Delivery);
    }

    public function getReceptionList()
    {
        $result = [];
        foreach ($this->receptions as $day => $time) {
            $result[Yii::t('novaposhta/default', $day)] = $time;
        }
        return $result;
    }

    public function getScheduleList()
    {
        $result = [];
        foreach ($this->schedule as $day => $time) {
            $result[Yii::t('novaposhta/default', $day)] = $time;
        }
        return $result;
    }

    public function getDeliveryList()
    {
        $result = [];
        foreach ($this->delivery as $day => $time) {
            $result[Yii::t('novaposhta/default', $day)] = $time;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_description'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['full_description'], 'string'],
            [['name'], 'trim'],
            [['updated_at', 'created_at'], 'safe'],


            [['short_description', 'image'], 'default'],
        ];
    }

    public static function getList($city_id = false)
    {
        $result = [];
        $query = self::find();
        if ($city_id) {
            $query->where(['CityRef' => $city_id]);
        }
        $list = $query->asArray()->all();
        if ($list) {
            foreach ($list as $item) {
                $result[$item['Ref']] = (Yii::$app->language === 'ru') ? $item['DescriptionRu'] : $item['Description'];
            }
        } else {
            if ($city_id) {
                $city = $city_id;
            } else {
                $city = '';
            }
            $list = Yii::$app->novaposhta->getWarehouses($city);
            if ($list['success']) {
                foreach ($list['data'] as $item) {
                    $result[$item['Ref']] = (Yii::$app->language === 'ru') ? $item['DescriptionRu'] : $item['Description'];
                }
            }
        }


        return $result;
    }


    public static function getList2($ref)
    {
        $lang = (Yii::$app->language == 'ru') ? 'ru' : 'uk';
        //$items = Yii::$app->cache->get("np_warehouses_{$lang}_{$ref}");

        //if ($items === false) {
            $result = Yii::$app->novaposhta->model('Address')
                ->method('getWarehouses')
                ->params([
                    'CityRef' => $ref,
                    'Limit' => 999,
                    'Page' => 1,
                    'TypeOfWarehouseRef' => '9a68df70-0267-42a8-bb5c-37f427e36ee4' //'9a68df70-0267-42a8-bb5c-37f427e36ee4', '841339c7-591a-42e2-8233-7a0a00f0ed6f'
                ])
                ->execute();

            if ($result['success']) {
                $items = [];
                foreach ($result['data'] as $item) {
                    $items[$item['Ref']] = (Yii::$app->language == 'ru') ? $item['DescriptionRu'] : $item['Description'];
                }
                //Yii::$app->cache->set("np_warehouses_{$lang}_{$ref}", $items, 86400 * 7);
            }
        //}

        return $items;
    }

}
