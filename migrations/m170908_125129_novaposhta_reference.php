<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125129_novaposhta_reference
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\CargoTypes;
use panix\mod\novaposhta\models\Errors;
use panix\mod\novaposhta\models\OwnershipForms;
use panix\mod\novaposhta\models\Packs;
use panix\mod\novaposhta\models\Pallets;
use panix\mod\novaposhta\models\ServiceTypes;
use panix\mod\novaposhta\models\TiresWheels;
use panix\mod\novaposhta\models\TypesCounterparties;
use panix\mod\novaposhta\models\TypesOfPayersForRedelivery;
use Yii;

class m170908_125129_novaposhta_reference extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Packs::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(255)->null(),
            'DescriptionRu' => $this->string(255)->null(),
            'Length' => $this->decimal(10, 1)->null(),
            'Width' => $this->decimal(10, 1)->null(),
            'Height' => $this->decimal(10, 1)->null(),
            'VolumetricWeight' => $this->decimal(10, 2)->null(),
            'TypeOfPacking' => $this->string(36)->null(),
            'PackagingForPlace' => $this->string(36)->null(),
        ], $tableOptions);
        $this->addPrimaryKey('Ref', Packs::tableName(), 'Ref');
        //$this->createIndex('Ref', Packs::tableName(), 'Ref');

        $this->createTable(Pallets::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(255)->null(),
            'DescriptionRu' => $this->string(255)->null(),
            'Weight' => $this->decimal(10, 2)->null(),
        ], $tableOptions);


        //$this->createIndex('Ref', Pallets::tableName(), 'Ref');
        $this->addPrimaryKey('Ref', Pallets::tableName(), 'Ref');


        $this->createTable(CargoTypes::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(36)->null(),
        ], $tableOptions);

        //$this->createIndex('Ref', CargoTypes::tableName(), 'Ref');
        $this->addPrimaryKey('Ref', CargoTypes::tableName(), 'Ref');

        $this->createTable(TypesOfPayersForRedelivery::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(36)->null(),
        ], $tableOptions);

        $this->createIndex('Ref', TypesOfPayersForRedelivery::tableName(), 'Ref');


        $this->createTable(TiresWheels::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(36)->null(),
            'DescriptionRu' => $this->string(36)->null(),
            'Weight' => $this->string(36)->null(),
            'DescriptionType' => $this->string(36)->null(),
        ], $tableOptions);

        $this->createIndex('Ref', TiresWheels::tableName(), 'Ref');


        $this->createTable(TypesCounterparties::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(36)->null(),
        ], $tableOptions);
        $this->addPrimaryKey('Ref', TypesCounterparties::tableName(), 'Ref');


        $this->createTable(ServiceTypes::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(36)->null(),
        ], $tableOptions);

        $this->addPrimaryKey('Ref', ServiceTypes::tableName(), 'Ref');

        $this->createTable(OwnershipForms::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(255)->null(),
            'FullName' => $this->string(255)->null(),
        ], $tableOptions);

        $this->addPrimaryKey('Ref', OwnershipForms::tableName(), 'Ref');


    }

    public function down()
    {
        $this->dropTable(Packs::tableName());
        $this->dropTable(Pallets::tableName());
        $this->dropTable(CargoTypes::tableName());
        $this->dropTable(TypesOfPayersForRedelivery::tableName());
        $this->dropTable(TiresWheels::tableName());
        $this->dropTable(TypesCounterparties::tableName());
        $this->dropTable(ServiceTypes::tableName());
        $this->dropTable(OwnershipForms::tableName());

    }

}
