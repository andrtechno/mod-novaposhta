<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125129_novaposhta_reference
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\Settlements;


class m170928_125182_novaposhta_settlements extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Settlements::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(50)->null(),
            'DescriptionRu' => $this->string(50)->null(),
            'DescriptionTranslit' => $this->string(50)->null(),
            'Latitude' => $this->string(36)->null(),
            'Longitude' => $this->string(36)->null(),
            'SettlementType' => $this->string(36)->null(),
            'SettlementTypeDescription' => $this->string(36)->null(),
            'SettlementTypeDescriptionRu' => $this->string(36)->null(),
            'SettlementTypeDescriptionTranslit' => $this->string(36)->null(),
            'Region' => $this->string(36)->null(),
            'RegionsDescription' => $this->string(50)->null(),
            'RegionsDescriptionRu' => $this->string(50)->null(),
            'RegionsDescriptionTranslit' => $this->string(50)->null(),
            'Area' => $this->string(36)->null(),
            'AreaDescription' => $this->string(50)->null(),
            'AreaDescriptionRu' => $this->string(50)->null(),
            'AreaDescriptionTranslit' => $this->string(50)->null(),
            'IndexCOATSU1' => $this->string(36)->null(),
            'Index1' => $this->string(10)->null(),
            'Index2' => $this->string(10)->null(),
            'Delivery1' => $this->string(36)->null(),
            'Delivery2' => $this->string(36)->null(),
            'Delivery3' => $this->string(36)->null(),
            'Delivery4' => $this->string(36)->null(),
            'Delivery5' => $this->string(36)->null(),
            'Delivery6' => $this->string(36)->null(),
            'Delivery7' => $this->string(36)->null(),
            'Warehouse' => $this->string(36)->null(),

        ], $tableOptions);

        $this->createIndex('Ref', Settlements::tableName(), 'Ref');

        if ($this->db->driverName != 'pgsql') {
             $this->addPrimaryKey('Ref', Settlements::tableName(), 'Ref');
        }

    }

    public function down()
    {
        $this->dropTable(Settlements::tableName());

    }

}
