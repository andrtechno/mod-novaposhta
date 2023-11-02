<?php

namespace panix\mod\novaposhta\commands;

use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\CargoTypes;
use panix\mod\novaposhta\models\Cities;
use panix\mod\novaposhta\models\Errors;
use panix\mod\novaposhta\models\OwnershipForms;
use panix\mod\novaposhta\models\Packs;
use panix\mod\novaposhta\models\Pallets;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\Settlements;
use panix\mod\novaposhta\models\TiresWheels;
use panix\mod\novaposhta\models\TypesCounterparties;
use panix\mod\novaposhta\models\TypesOfPayersForRedelivery;
use panix\mod\novaposhta\models\WarehouseTypes;
use Yii;
use panix\engine\console\controllers\ConsoleController;
use yii\helpers\Console;

/**
 * NovaposhtaController
 * @package panix\mod\novaposhta\commands
 */
class NovaposhtaController extends ConsoleController
{
    /**
     * @var Novaposhta
     */
    private $api;

    public function beforeAction($action)
    {
        $this->api = Yii::$app->novaposhta;
        return parent::beforeAction($action);
    }

    public function actionIsWh()
    {
        $cities = Cities::find()->limit(10000)->where(['warehouse' => 0])->all();
        foreach ($cities as $c) {
            if ($c->getWarehouses()->count()) {
                $c->warehouse = 1;
                $c->save(false);
            }

        }
    }

    /**
     * First LOAD
     */
    public function actionIndex()
    {
        Settlements::loadAll();
        WarehouseTypes::loadAll();
    }

    /**
     * Update cities
     */
    public function actionCities()
    {
        Cities::getDb()->createCommand()->truncateTable(Cities::tableName())->execute();
        $cities = $this->api->getCities(0, 99999);

        $fields = [
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
        if ($cities['success']) {
            $data = [];
            foreach ($cities['data'] as $k => $city) {
                $data[] = [
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
                ];

            }

            Cities::getDb()->createCommand()->batchInsert(Cities::tableName(), $fields, $data)->execute();
        }
    }

    /**
     * Update warehouses
     */
    public function __actionWarehouses()
    {


        //Warehouses::getDb()->createCommand()->truncateTable(Warehouses::tableName())->execute();


        $result = $this->api
            ->model('Address')
            ->method('getWarehouses')->params([
                'TypeOfWarehouseRef' => '841339c7-591a-42e2-8233-7a0a00f0ed6f' //Почтовое отделение
            ])
            ->execute();


        $list = [];
        $total = count($result['data']);
        $i = 0;

        foreach ($result['data'] as $d) {
            $i++;
            $list[] = [
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
        ], $list)->execute();
    }

    /**
     * Recommend run one month for update db
     * @throws \yii\db\Exception
     */
    public function actionErrors()
    {
        Errors::loadAll();
    }

    /**
     * Update references
     */
    public function actionReference()
    {


        //$typesOfPayers = $this->api->getTypesOfPayers();
        //print_r($typesOfPayers);


        //$backwardDeliveryCargoTypes = $this->api->getBackwardDeliveryCargoTypes();
        //print_r($backwardDeliveryCargoTypes);


        /* $Payment = $this->api
             ->model('Common')
             ->method('getPaymentForms')
             ->execute();*/

        /*$statuses = $this->api
            ->model('Common')
            ->method('getDocumentStatuses')
            ->execute();

        $test = $this->api
            ->model('Common')
            ->method('getBackwardDeliveryCargoTypes')
            ->execute();*/


        CargoTypes::loadAll();
        Pallets::loadAll();
        Packs::loadAll();
        OwnershipForms::loadAll();
        TypesOfPayersForRedelivery::loadAll();
        TiresWheels::loadAll();
        TypesCounterparties::loadAll();
        ServiceTypes::loadAll();

    }
}
