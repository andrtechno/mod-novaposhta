<?php

namespace panix\mod\novaposhta\components;

use panix\engine\CMS;
use panix\mod\novaposhta\models\Cities;
use panix\mod\novaposhta\models\Warehouses;
use Yii;
use panix\mod\shop\models\Product;
use yii\base\BaseObject;
use yii\helpers\Console;
use yii\queue\JobInterface;

/**
 * Class QueueWarehouse
 */
class QueueWarehouse extends BaseObject implements JobInterface
{
    public $page = 1;
    public $limit = 100;
    //public $typeOfWarehouseRef = '841339c7-591a-42e2-8233-7a0a00f0ed6f'; //Почтовое отделение

    public function execute($queue)
    {
        $result = Yii::$app->novaposhta->model('Address')
            ->method('getWarehouses')->params([
                'Limit' => $this->limit,
                'Page'=>$this->page,
                //'TypeOfWarehouseRef' => $this->typeOfWarehouseRef
            ])
            ->execute();

        if($result['success']){
            foreach ($result['data'] as $d) {

                $data[] = [
                    $d['SiteKey'],
                    $d['Description'],
                    $d['DescriptionRu'],
                    $d['ShortAddress'],
                    $d['ShortAddressRu'],
                    $d['Phone'],
                    $d['TypeOfWarehouse'],
                    $d['Ref'],
                    $d['Number'],
                    $d['CityRef'],
                    $d['CityDescription'],
                    $d['CityDescriptionRu'],
                    $d['SettlementRef'],
                    $d['SettlementDescription'],
                    $d['SettlementAreaDescription'],
                    $d['SettlementRegionsDescription'],
                    $d['SettlementTypeDescription'],
                    $d['Longitude'],
                    $d['Latitude'],
                    $d['PostFinance'],
                    $d['BicycleParking'],
                    $d['PaymentAccess'],
                    $d['POSTerminal'],
                    $d['InternationalShipping'],
                    $d['SelfServiceWorkplacesCount'],
                    $d['TotalMaxWeightAllowed'],
                    $d['PlaceMaxWeightAllowed'],
                    (is_array($d['Reception'])) ? json_encode($d['Reception']) : $d['Reception'],
                    (is_array($d['Delivery'])) ? json_encode($d['Delivery']) : $d['Delivery'],
                    (is_array($d['Schedule'])) ? json_encode($d['Schedule']) : $d['Schedule'],
                    $d['DistrictCode'],
                    $d['WarehouseStatus'],
                    $d['WarehouseStatusDate'],
                    $d['CategoryOfWarehouse'],
                    $d['Direct'],
                ];

            }

            Warehouses::getDb()->createCommand()->batchInsert(Warehouses::tableName(), [
                'SiteKey',
                'Description',
                'DescriptionRu',
                'ShortAddress',
                'ShortAddressRu',
                'Phone',
                'TypeOfWarehouse',
                'Ref',
                'Number',
                'CityRef',
                'CityDescription',
                'CityDescriptionRu',
                'SettlementRef',
                'SettlementDescription',
                'SettlementAreaDescription',
                'SettlementRegionsDescription',
                'SettlementTypeDescription',
                'Longitude',
                'Latitude',
                'PostFinance',
                'BicycleParking',
                'PaymentAccess',
                'POSTerminal',
                'InternationalShipping',
                'SelfServiceWorkplacesCount',
                'TotalMaxWeightAllowed',
                'PlaceMaxWeightAllowed',
                'Reception',
                'Delivery',
                'Schedule',
                'DistrictCode',
                'WarehouseStatus',
                'WarehouseStatusDate',
                'CategoryOfWarehouse',
                'Direct',
            ], $data)->execute();
        }

        return true;
    }
}