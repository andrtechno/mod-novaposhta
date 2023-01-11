<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125124_novaposhta_warehouses
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\WarehouseTypes;

class m170908_122114_novaposhta_warehousetypes extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable(WarehouseTypes::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(50)->null(),
            'DescriptionRu' => $this->string(50)->null(),
        ], $tableOptions);

        if ($this->db->driverName != 'pgsql') {
            $this->addPrimaryKey('Ref', WarehouseTypes::tableName(), 'Ref');
        }

    }

    public function safeDown()
    {
        try {
            $this->dropTable(WarehouseTypes::tableName());
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return __CLASS__ . " was reverted.\n";
    }


}
