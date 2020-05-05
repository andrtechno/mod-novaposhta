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
use panix\mod\pages\models\Pages;
use panix\mod\pages\models\PagesTranslate;
class m170908_125123_novaposhta extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Pages::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'slug' => $this->string(255)->notNull(),
            'views' => $this->integer()->defaultValue(0),
            'ordern' => $this->integer()->unsigned(),
            'switch' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null()
        ], $tableOptions);


        $this->createTable(PagesTranslate::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'object_id' => $this->integer()->unsigned(),
            'language_id' => $this->tinyInteger()->unsigned(),
            'name' => $this->string(255),
            'text' => $this->text()
        ], $tableOptions);


        $this->createIndex('switch', Pages::tableName(), 'switch');
        $this->createIndex('ordern', Pages::tableName(), 'ordern');
        $this->createIndex('user_id', Pages::tableName(), 'user_id');
        $this->createIndex('slug', Pages::tableName(), 'slug');

        $this->createIndex('object_id', PagesTranslate::tableName(), 'object_id');
        $this->createIndex('language_id', PagesTranslate::tableName(), 'language_id');

        if ($this->db->driverName != "sqlite") {
            $this->addForeignKey('{{%fk_pages_translate}}', PagesTranslate::tableName(), 'object_id', Pages::tableName(), 'id', "CASCADE", "NO ACTION");
        }

        $columns = ['slug', 'user_id', 'ordern', 'created_at'];
        $this->batchInsert(Pages::tableName(), $columns, [
            ['about', 1, 1, time()],
            ['mypage', 1, 2, time()],
        ]);


        $columns = ['object_id', 'language_id', 'name', 'text'];
        $this->batchInsert(PagesTranslate::tableName(), $columns, [
            [1, 1, 'О компании', ''],
            [2, 1, 'Тест', ''],
        ]);
    }

    public function down()
    {
        if ($this->db->driverName != "sqlite") {
            $this->dropForeignKey('{{%fk_pages_translate}}', PagesTranslate::tableName());
        }
        $this->dropTable(Pages::tableName());
        $this->dropTable(PagesTranslate::tableName());
    }

}
