<?php

namespace panix\mod\novaposhta\commands;

use panix\mod\novaposhta\components\Novaposhta;
use panix\mod\novaposhta\models\Area;
use panix\mod\novaposhta\models\CargoTypes;
use panix\mod\novaposhta\models\Cities;
use panix\mod\novaposhta\models\Errors;
use panix\mod\novaposhta\models\OwnershipForms;
use panix\mod\novaposhta\models\Packs;
use panix\mod\novaposhta\models\Pallets;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\TiresWheels;
use panix\mod\novaposhta\models\TypesCounterparties;
use panix\mod\novaposhta\models\TypesOfPayersForRedelivery;
use panix\mod\novaposhta\models\Warehouses;
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

    /**
     * Update cities
     */
    public function actionCities()
    {
        Cities::getDb()->createCommand()->truncateTable(Cities::tableName())->execute();
        $cities = $this->api->getCities();

        $s = [
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
                $data2[] = array_values($city);


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
                    (is_array($city['Conglomerates'])) ? json_encode($city['Conglomerates']) : $city['Conglomerates'],
                    $city['CityID'],
                    $city['SettlementTypeDescription'],
                    $city['SettlementTypeDescriptionRu'],
                    $city['SpecialCashCheck'],
                    $city['AreaDescription'],
                    $city['AreaDescriptionRu'],
                ];

            }

            Cities::getDb()->createCommand()->batchInsert(Cities::tableName(), $s, $data)->execute();
        }
    }

    /**
     * Update warehouses
     */
    public function actionWarehouses()
    {


        Warehouses::getDb()->createCommand()->truncateTable(Warehouses::tableName())->execute();

        $result = $this->api
            ->model('Address')
            ->method('getWarehouses')
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
     * Update areas
     */
    public function actionArea()
    {


        Area::getDb()->createCommand()->truncateTable(Area::tableName())->execute();

        $result = $this->api
            ->model('Address')
            ->method('getAreas')
            ->execute();


        if ($result['success']) {
            $total = count($result['data']);
            $i = 0;
            Console::startProgress($i, $total);
            $list = [];

            foreach ($result['data'] as $key => $d) {
                $i++;
                $list[] = array_values($d);
                Console::updateProgress($i, $total);
            }
            Area::getDb()->createCommand()->batchInsert(Area::tableName(), array_keys($result['data'][0]), $list)->execute();
            Console::endProgress(false);
        }
    }

    /**
     * Recommend run one month for update db
     * @throws \yii\db\Exception
     */
    public function actionErrors()
    {
        Errors::getDb()->createCommand()->truncateTable(Errors::tableName())->execute();
        $response = $this->api->model('CommonGeneral')->method('getMessageCodeText')->execute();

        if ($response['success']) {
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            Errors::getDb()->createCommand()->batchInsert(Errors::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
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

        $statuses = $this->api
            ->model('Common')
            ->method('getDocumentStatuses')
            ->execute();

        $test = $this->api
            ->model('Common')
            ->method('getBackwardDeliveryCargoTypes')
            ->execute();


//print_r($test);die;


        $this->cargoTypes();
        $this->pallets();
        $this->ownershipForms();
        $this->packs();
        $this->typesOfPayersForRedelivery();
        $this->tiresWheelsList();
        $this->typesOfCounterparties();
        $this->serviceTypes();

    }

    private function cargoTypes()
    {
        CargoTypes::getDb()->createCommand()->truncateTable(CargoTypes::tableName())->execute();
        $response = $this->api->getCargoTypes();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            CargoTypes::getDb()->createCommand()->batchInsert(CargoTypes::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function pallets()
    {
        Pallets::getDb()->createCommand()->truncateTable(Pallets::tableName())->execute();
        $response = $this->api->getPalletsList();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            Pallets::getDb()->createCommand()->batchInsert(Pallets::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function typesOfPayersForRedelivery()
    {
        TypesOfPayersForRedelivery::getDb()->createCommand()->truncateTable(TypesOfPayersForRedelivery::tableName())->execute();
        $response = $this->api->getTypesOfPayersForRedelivery();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            TypesOfPayersForRedelivery::getDb()->createCommand()->batchInsert(TypesOfPayersForRedelivery::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function tiresWheelsList()
    {
        TiresWheels::getDb()->createCommand()->truncateTable(TiresWheels::tableName())->execute();
        $response = $this->api->getTiresWheelsList();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            TiresWheels::getDb()->createCommand()->batchInsert(TiresWheels::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function typesOfCounterparties()
    {
        TypesCounterparties::getDb()->createCommand()->truncateTable(TypesCounterparties::tableName())->execute();
        $response = $this->api->getTypesOfCounterparties();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            TypesCounterparties::getDb()->createCommand()->batchInsert(TypesCounterparties::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function serviceTypes()
    {
        ServiceTypes::getDb()->createCommand()->truncateTable(ServiceTypes::tableName())->execute();
        $response = $this->api->getServiceTypes();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            ServiceTypes::getDb()->createCommand()->batchInsert(ServiceTypes::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function packs()
    {
        Packs::getDb()->createCommand()->truncateTable(Packs::tableName())->execute();
        $response = $this->api
            ->model('Common')
            ->method('getPackList')
            ->execute();
        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            Packs::getDb()->createCommand()->batchInsert(Packs::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

    private function ownershipForms()
    {
        OwnershipForms::getDb()->createCommand()->truncateTable(OwnershipForms::tableName())->execute();
        $response = $this->api
            ->model('Common')
            ->method('getOwnershipFormsList')
            ->execute();

        if ($response['success']) {
            $data = [];
            foreach ($response['data'] as $item) {
                $data[] = array_values($item);
            }
            OwnershipForms::getDb()->createCommand()->batchInsert(OwnershipForms::tableName(), array_keys($response['data'][0]), $data)->execute();
        }
    }

}
