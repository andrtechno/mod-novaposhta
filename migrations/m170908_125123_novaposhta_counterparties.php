<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125123_novaposhta_counterparties
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\counterparties\Counterparties;


class m170908_125123_novaposhta_counterparties extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable(Counterparties::tableName(), [
            'Ref' => $this->string(36)->null(),
            'Description' => $this->string(255)->null(),
            'City' => $this->string(36)->null(),
            'Counterparty' => $this->string(255)->null(),
            'FirstName' => $this->string(255)->null(),
            'LastName' => $this->string(255)->null(),
            'MiddleName' => $this->string(255)->null(),
            'CounterpartyFullName' => $this->string(255)->null(),
            'OwnershipFormRef' => $this->string(36)->null(),
            'OwnershipFormDescription' => $this->string(255)->null(),
            'EDRPOU' => $this->string(255)->null(),
            'CounterpartyType' => $this->string(255)->null(),
            'CityDescription' => $this->string(255)->null(),

        ], $tableOptions);

        $this->addPrimaryKey('Ref', Counterparties::tableName(), 'Ref');

    }

    public function down()
    {
        $this->dropTable(Counterparties::tableName());
    }

}
