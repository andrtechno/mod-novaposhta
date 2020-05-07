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
            'description' => $this->string(255)->null(),
            'description_ru' => $this->string(255)->null(),
            'ref' => $this->string(255)->null(),
            'delivery1' => $this->tinyInteger(1)->defaultValue(0),
            'delivery2' => $this->tinyInteger(1)->defaultValue(0),
            'delivery3' => $this->tinyInteger(1)->defaultValue(0),
            'delivery4' => $this->tinyInteger(1)->defaultValue(0),
            'delivery5' => $this->tinyInteger(1)->defaultValue(0),
            'delivery6' => $this->tinyInteger(1)->defaultValue(0),
            'delivery7' => $this->tinyInteger(1)->defaultValue(0),
            'area' => $this->string(255)->null(),
            'settlementType' => $this->string(255)->null(),
            'isBranch' => $this->tinyInteger(1)->defaultValue(0),
            'preventEntryNewStreetsUser' => $this->string(255)->null(),
            'conglomerates' => $this->string(255)->null(),
            'cityID' => $this->integer()->null(),
            'settlementTypeDescriptionRu' => $this->string(255)->null(),
            'settlementTypeDescription' => $this->string(255)->null(),
            'specialCashCheck' => $this->string(1)->null(),
            'postomat' => $this->tinyInteger(1)->null(),
            'areaDescription' => $this->string(255)->null(),
            'areaDescriptionRu' => $this->string(255)->null(),
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
