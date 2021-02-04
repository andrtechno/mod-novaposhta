<?php

namespace panix\mod\novaposhta\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125129_novaposhta_expressinvoice
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\ExpressInvoice;
use Yii;

class m170908_125129_novaposhta_expressinvoice extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(ExpressInvoice::tableName(), [
            //'id' => $this->primaryKey()->unsigned(),
            'Ref' => $this->string(36)->null(),
            'order_id' => $this->integer()->unsigned()->null(),
            'PayerType' => $this->string(36)->null(),
            'PaymentMethod' => $this->string(36)->null(),
            'DateTime' => $this->string(36)->null(),
            'CargoType' => $this->string(36)->null(),
            'VolumeGeneral' => $this->string(36)->null(),
            'Weight' => $this->string(36)->null(),
            'ServiceType' => $this->string(36)->null(),
            'SeatsAmount' => $this->string(36)->null(),
            'Description' => $this->string(50)->null(),
            'Cost' => $this->string(36)->null(),
            'CitySender' => $this->string(36)->null(),
            'Sender' => $this->string(36)->null(),
            'SenderAddress' => $this->string(36)->null(),
            'ContactSender' => $this->string(36)->null(),
            'SendersPhone' => $this->string(36)->null(),
            'CityRecipient' => $this->string(36)->null(),
            'Recipient' => $this->string(36)->null(),
            'RecipientAddress' => $this->string(36)->null(),
            'ContactRecipient' => $this->string(36)->null(),
            'RecipientsPhone' => $this->string(36)->null(),
        ], $tableOptions);

        $this->addPrimaryKey('Ref', ExpressInvoice::tableName(), 'Ref');
        //$this->createIndex('Ref', ExpressInvoice::tableName(), 'Ref');
        $this->createIndex('order_id', ExpressInvoice::tableName(), 'order_id');

    }

    public function down()
    {
        $this->dropTable(ExpressInvoice::tableName());

    }

}
