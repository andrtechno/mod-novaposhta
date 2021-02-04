<?php


/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125126_novaposhta_street
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\Street;

class m170908_125126_novaposhta_street extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable(Street::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(100)->null(),
            'StreetsTypeRef' => $this->string(36)->null(),
            'StreetsType' => $this->string(255)->null(),

        ], $tableOptions);

        $this->addPrimaryKey('Ref', Street::tableName(), 'Ref');
        //$this->createIndex('Ref', Street::tableName(), 'Ref');
        $this->createIndex('StreetsTypeRef', Street::tableName(), 'StreetsTypeRef');

    }

    public function down()
    {
        $this->dropTable(Street::tableName());
    }

}
