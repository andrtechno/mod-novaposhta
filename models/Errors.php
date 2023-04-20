<?php

namespace panix\mod\novaposhta\models;

use Yii;

/**
 * This is the model class for table "novaposhta_errors".
 *
 * @property int $MessageCode
 * @property string $MessageText
 * @property string $MessageDescriptionRU
 * @property string $MessageDescriptionUA
 */
class Errors extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__errors}}';
    }

    /**
     * @param integer $code
     * @return string
     */
    public static function run($code)
    {
        $find = parent::findOne(['MessageCode' => $code]);
        return ($find) ? $find->getMessage() : $code;
    }

    public function getMessage()
    {
        $lang = Yii::$app->language;
        if ($lang == 'ua' && $this->MessageDescriptionUA) {
            return $this->MessageDescriptionUA;
        } elseif ($lang == 'ru' && $this->MessageDescriptionRU) {
            return $this->MessageDescriptionRU;
        }
        return $this->MessageText;
    }

    public static function loadAll()
    {

        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $response = Yii::$app->novaposhta->model('CommonGeneral')->method('getMessageCodeText')->execute();

        if ($response['success']) {
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }
}
