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
    public $data;
    private $fields = [
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
    ];

    public function execute($queue)
    {


        foreach ($this->data as $d) {

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

         Warehouses::getDb()->createCommand()->batchInsert(Warehouses::tableName(), $this->fields, $data)->execute();
        return true;
    }
}