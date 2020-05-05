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
use panix\mod\novaposhta\models\NovaposhtaCities;

class m170908_125123_novaposhta extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(NovaposhtaCities::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'city_id' => $this->string(255)->notNull(),
            'name' => $this->string(255)->null(),
            'name_ua' => $this->string(255)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null()
        ], $tableOptions);


        $this->createIndex('city_id', NovaposhtaCities::tableName(), 'city_id');

    }

    public function down()
    {
        $this->dropTable(NovaposhtaCities::tableName());
    }

}
