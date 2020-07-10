<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125125_novaposhta_area
 */
use panix\engine\db\Migration;
use panix\mod\novaposhta\models\Area;
use Yii;

class m170908_125125_novaposhta_area extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }




        $this->createTable(Area::tableName(), [
            'Ref' => $this->string(36)->null(),
            'AreasCenter' => $this->string(255)->null(),
            'DescriptionRu' => $this->string(255)->null(),
            'Description' => $this->string(255)->null(),

        ], $tableOptions);

        $this->addPrimaryKey('Ref', Area::tableName(), 'Ref');
        //$this->createIndex('Ref', Area::tableName(), 'Ref');

    }

    public function down()
    {
        $this->dropTable(Area::tableName());
    }

}
