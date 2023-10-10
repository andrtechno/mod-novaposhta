<?php

namespace panix\mod\novaposhta\models;

use Yii;

/**
 * This is the model class for table "novaposhta_area".
 *
 * @property string $Ref Guid
 * @property string $Description
 * @property string $DescriptionRu
 * @property string $AreasCenter
 */
class Area extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__area}}';
    }

    public function getDescription()
    {
        return (Yii::$app->language == 'ru') ? $this->DescriptionRu : $this->Description;
    }

    public static function getList()
    {
        $result = [];
        $list = self::find()->asArray()->all();
        if ($list) {
            foreach ($list as $item) {
                $result[$item['Ref']] = $item['DescriptionRu'];
            }
        } else {
            $list = Yii::$app->novaposhta->getArea();
            if ($list['success']) {
                foreach ($list['data'] as $item) {
                    $result[$item['Ref']] = $item['DescriptionRu'];
                }
            }
        }


        return $result;
    }

    public static function getList2()
    {
        $lang = (Yii::$app->language == 'ru') ? 'ru' : 'uk';
        $items = Yii::$app->cache->get("np_area_{$lang}");

        if ($items === false) {
            $result = Yii::$app->novaposhta->model('Address')->method('getAreas')->execute();

            if ($result['success']) {
                $items = [];
                foreach ($result['data'] as $item) {
                    $items[$item['Ref']] = (Yii::$app->language == 'ru') ? $item['DescriptionRu'] : $item['Description'];
                }
                Yii::$app->cache->set("np_area_{$lang}", $items,0);
            }else{
                throw new ErrorException('NovaPoshta: '.$result['errors'][0]);
            }
        }
        return $items;
    }
}
