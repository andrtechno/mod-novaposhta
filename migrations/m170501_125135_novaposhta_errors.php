<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170501_125135_novaposhta_errors
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\Errors;

class m170501_125135_novaposhta_errors extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Errors::tableName(), [
            'MessageCode' => $this->integer()->null(),
            'MessageText' => $this->text()->null(),
            'MessageDescriptionRU' => $this->text()->null(),
            'MessageDescriptionUA' => $this->text()->null(),
        ], $tableOptions);
        $this->addPrimaryKey('MessageCode', Errors::tableName(), 'MessageCode');

    }

    public function down()
    {
        $this->dropTable(Errors::tableName());

    }

}
