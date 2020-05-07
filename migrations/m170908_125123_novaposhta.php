<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125123_novaposhta
 */
use Yii;
use yii\db\Migration;
use panix\mod\novaposhta\models\Cities;

class m170908_125123_novaposhta extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Cities::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'Description' => $this->string(50)->null(),
            'DescriptionRu' => $this->string(50)->null(),
            'Ref' => $this->string(36)->null(),
            'Delivery1' => $this->tinyInteger(1)->defaultValue(0),
            'Delivery2' => $this->tinyInteger(1)->defaultValue(0),
            'Delivery3' => $this->tinyInteger(1)->defaultValue(0),
            'Delivery4' => $this->tinyInteger(1)->defaultValue(0),
            'Delivery5' => $this->tinyInteger(1)->defaultValue(0),
            'Delivery6' => $this->tinyInteger(1)->defaultValue(0),
            'Delivery7' => $this->tinyInteger(1)->defaultValue(0),
            'Area' => $this->string(36)->null(),
            'SettlementType' => $this->string(36)->null(),
            'IsBranch' => $this->tinyInteger(1)->defaultValue(0),
            'PreventEntryNewStreetsUser' => $this->string(255)->null(),
            'Conglomerates' => $this->string(255)->null(),
            'CityID' => $this->integer()->null(),
            'SettlementTypeDescriptionRu' => $this->string(36)->null(),
            'SettlementTypeDescription' => $this->string(36)->null(),
            'SpecialCashCheck' => $this->string(1)->null(),
            'Postomat' => $this->tinyInteger(1)->null(),
            'AreaDescription' => $this->string(255)->null(),
            'AreaDescriptionRu' => $this->string(255)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),

        ], $tableOptions);


        $this->createIndex('ref', Cities::tableName(), 'ref');

    }

    public function down()
    {
        $this->dropTable(Cities::tableName());
    }

}
