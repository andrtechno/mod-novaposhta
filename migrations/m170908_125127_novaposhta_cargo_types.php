<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125127_novaposhta_cargo_types
 */
use panix\engine\db\Migration;
use panix\mod\novaposhta\models\CargoTypes;
use Yii;

class m170908_125127_novaposhta_cargo_types extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(CargoTypes::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(36)->null(),

        ], $tableOptions);


        $this->createIndex('Ref', CargoTypes::tableName(), 'Ref');

    }

    public function down()
    {
        $this->dropTable(CargoTypes::tableName());
    }

}
