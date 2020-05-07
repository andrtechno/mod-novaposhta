<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125123_novaposhta_counterparties
 */
use panix\engine\db\Migration;
use panix\mod\novaposhta\models\counterparties\Counterparties;
use Yii;

class m170908_125123_novaposhta_counterparties extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable(Counterparties::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'ref' => $this->string(255)->null(),
            'first_name' => $this->string(255)->null(),
            'last_name' => $this->string(255)->null(),
            'middle_name' => $this->string(255)->null(),
            'phone' => $this->phone(),
            'email' => $this->string(255)->null(),
            'type' => $this->string(255)->null(),
            'property' => $this->string(255)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null()
        ], $tableOptions);


       // $this->createIndex('city_id', Counterparties::tableName(), 'city_id');

    }

    public function down()
    {
        $this->dropTable(Counterparties::tableName());
    }

}
