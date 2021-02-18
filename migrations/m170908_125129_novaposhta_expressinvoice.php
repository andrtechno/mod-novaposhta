<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_125129_novaposhta_expressinvoice
 */

use panix\engine\db\Migration;
use panix\mod\novaposhta\models\ExpressInvoice;

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


            'IntDocNumber'=>$this->integer(11)->unsigned()->null()->comment('afterSave'),
            'CostOnSite'=>$this->money(10,2)->null()->comment('afterSave'),
            'ContactRecipient'=>$this->string(255)->null()->comment('afterSave'),
            'CityRecipient'=>$this->string(255)->null()->comment('afterSave'),
            'RecipientAddress'=>$this->string(255)->null()->comment('afterSave'),
            'CitySender'=>$this->string(255)->null()->comment('afterSave'),
            'SenderAddress'=>$this->string(255)->null()->comment('afterSave'),

            'OptionsSeat' => $this->text()->null(),
            'BackwardDeliveryData' => $this->text()->null(),




            'PayerType' => $this->string(36)->null(),
            'PaymentMethod' => $this->string(36)->null(),
            'DateTime' => $this->string(36)->null(),
            'CargoType' => $this->string(36)->null(),
            'VolumeGeneral' => $this->string(36)->null(),
            'Weight' => $this->string(36)->null(),
            'ServiceType' => $this->string(255)->null()->comment('afterSave'),
            'ServiceTypeRef' => $this->string(36)->null(),
            'SeatsAmount' => $this->string(36)->null(),
            'Description' => $this->string(50)->null(),
            'Cost' => $this->string(36)->null(),
            'CitySenderRef' => $this->string(36)->null(),
            'Sender' => $this->string(36)->null(),
            'SenderAddressRef' => $this->string(36)->null(),
            'ContactSender' => $this->string(36)->null(),
            'SendersPhone' => $this->string(36)->null(),
            'CityRecipientRef' => $this->string(36)->null(),
            'RecipientRef' => $this->string(36)->null(),
            'RecipientAddressRef' => $this->string(36)->null(),
            'ContactRecipientRef' => $this->string(36)->null(),
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
