<?php

namespace panix\mod\novaposhta\components;

use panix\engine\CMS;
use panix\mod\novaposhta\models\Cities;
use Yii;
use panix\mod\shop\models\Product;
use yii\base\BaseObject;
use yii\helpers\Console;
use yii\queue\JobInterface;

/**
 * Class QueueCities
 */
class QueueCities extends BaseObject implements JobInterface
{
    public $data;
    private $fields = [
        'Description',
        'DescriptionRu',
        'Ref',
        'Delivery1',
        'Delivery2',
        'Delivery3',
        'Delivery4',
        'Delivery5',
        'Delivery6',
        'Delivery7',
        'Area',
        'SettlementType',
        'IsBranch',
        'PreventEntryNewStreetsUser',
        'Conglomerates',
        'CityID',
        'SettlementTypeDescription',
        'SettlementTypeDescriptionRu',
        'SpecialCashCheck',
        'AreaDescription',
        'AreaDescriptionRu',
    ];

    public function execute($queue)
    {


        foreach ($this->data as $k => $city) {

            $data = Cities::findOne($city['Ref']);
            if(!$data){
                $data = new Cities;
                $data->Ref = $city['Ref'];
            }

            $data->Description = $city['Description'];
            $data->DescriptionRu = $city['DescriptionRu'];

            $data->Delivery1 = $city['Delivery1'];
            $data->Delivery2 = $city['Delivery2'];
            $data->Delivery3 = $city['Delivery3'];
            $data->Delivery4 = $city['Delivery4'];
            $data->Delivery5 = $city['Delivery5'];
            $data->Delivery6 = $city['Delivery6'];
            $data->Delivery7 = $city['Delivery7'];
            $data->Area = $city['Area'];
            $data->SettlementType = $city['SettlementType'];
            $data->IsBranch = $city['IsBranch'];
            $data->PreventEntryNewStreetsUser = $city['PreventEntryNewStreetsUser'];
            $data->Conglomerates = (isset($city['Conglomerates'])) ? (is_array($city['Conglomerates'])) ? json_encode($city['Conglomerates']) : $city['Conglomerates'] : null;
            $data->CityID = $city['CityID'];
            $data->SettlementTypeDescription = $city['SettlementTypeDescription'];
            $data->SettlementTypeDescriptionRu = $city['SettlementTypeDescriptionRu'];
            $data->SpecialCashCheck = $city['SpecialCashCheck'];
            $data->AreaDescription = $city['AreaDescription'];
            $data->AreaDescriptionRu = $city['AreaDescriptionRu'];
            $data->save(false);
            /*$data[] = [
                $city['Description'],
                $city['DescriptionRu'],
                $city['Ref'],
                $city['Delivery1'],
                $city['Delivery2'],
                $city['Delivery3'],
                $city['Delivery4'],
                $city['Delivery5'],
                $city['Delivery6'],
                $city['Delivery7'],
                $city['Area'],
                $city['SettlementType'],
                $city['IsBranch'],
                $city['PreventEntryNewStreetsUser'],
                (isset($city['Conglomerates'])) ? (is_array($city['Conglomerates'])) ? json_encode($city['Conglomerates']) : $city['Conglomerates'] : null,
                $city['CityID'],
                $city['SettlementTypeDescription'],
                $city['SettlementTypeDescriptionRu'],
                $city['SpecialCashCheck'],
                $city['AreaDescription'],
                $city['AreaDescriptionRu'],
            ];*/

        }

        // Cities::getDb()->createCommand()->batchInsert(Cities::tableName(), $this->fields, $data)->execute();
        return true;
    }
}