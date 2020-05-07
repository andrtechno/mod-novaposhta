<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125124_novaposhta_warehouses
 */
use panix\engine\db\Migration;
use panix\mod\novaposhta\models\Warehouses;
use Yii;

class m170908_125124_novaposhta_warehouses extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }




        $this->createTable(Warehouses::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'SiteKey' => $this->string(255)->null(),
            'Description' => $this->string(255)->null(),
            'DescriptionRu' => $this->string(255)->null(),
            'ShortAddress' => $this->string(255)->null(),
            'ShortAddressRu' => $this->string(255)->null(),
            'Phone' => $this->phone(),
            'TypeOfWarehouse' => $this->string(255)->null(),
            'Ref' => $this->string(255)->null(),
            'Number' => $this->tinyInteger(1),
            'CityRef' => $this->string(255)->null(),
            'CityDescription' => $this->string(255)->null(),
            'CityDescriptionRu' => $this->string(255)->null(),
            'SettlementRef' => $this->string(255)->null(),
            'SettlementDescription' => $this->string(255)->null(),
            'SettlementAreaDescription' => $this->string(255)->null(),
            'SettlementRegionsDescription' => $this->string(255)->null(),
            'SettlementTypeDescription' => $this->string(255)->null(),
            'Longitude' => $this->string(255)->null(),
            'Latitude' => $this->string(255)->null(),
            'PostFinance' => $this->tinyInteger(1)->defaultValue(0),
            'BicycleParking' => $this->tinyInteger(1)->defaultValue(0),
            'PaymentAccess' => $this->tinyInteger(1)->defaultValue(0),
            'POSTerminal' => $this->tinyInteger(1)->defaultValue(0),
            'InternationalShipping' => $this->tinyInteger(1)->defaultValue(0),
            'SelfServiceWorkplacesCount' => $this->tinyInteger(1)->defaultValue(0),
            'TotalMaxWeightAllowed' => $this->integer(11)->defaultValue(0),
            'PlaceMaxWeightAllowed' => $this->tinyInteger(1)->defaultValue(0),
            'Reception' => $this->text()->null(),
            'Delivery' => $this->text()->null(),
            'Schedule' => $this->text()->null(),
            'DistrictCode' => $this->string(255)->null(),
            'WarehouseStatus' => $this->string(255)->null(),
            'WarehouseStatusDate' => $this->string(255)->null(),
            'CategoryOfWarehouse' => $this->string(255)->null(),
            'Direct' => $this->string(255)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null()
        ], $tableOptions);


        $this->createIndex('CityRef', Counterparties::tableName(), 'CityRef');
        $this->createIndex('Ref', Counterparties::tableName(), 'Ref');
        $this->createIndex('SettlementRef', Counterparties::tableName(), 'SettlementRef');
    }

    public function down()
    {
        $this->dropTable(Warehouses::tableName());
    }

}
