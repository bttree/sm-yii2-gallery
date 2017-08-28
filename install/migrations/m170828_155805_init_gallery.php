<?php

use yii\db\Migration;

/**
 * Class m170828_155805_init_gallery
 */
class m170828_155805_init_gallery extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gallery}}',
                           [
                               'id'   => $this->primaryKey(),
                               'name' => $this->string()->notNull(),
                               'slug' => $this->string()->notNull(),
                           ],
                           $tableOptions);

        $this->createTable('{{%gallery_image}}',
                           [
                               'id'          => $this->integer()->notNull(),
                               'gallery_id'  => $this->integer()->notNull(),
                               'pos'         => $this->integer()->notNull(),
                               'name'        => $this->string(),
                               'src'         => $this->string(),
                               'description' => $this->text(),
                           ],
                           $tableOptions);

        $this->addForeignKey('fk_{{%gallery}}_images',
                             '{{%gallery_image}}',
                             'gallery_id',
                             '{{%gallery}}',
                             'id',
                             'CASCADE',
                             'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_{{%gallery}}_images', '{{%gallery_image}}');
        $this->dropTable('{{%gallery_image}}');
        $this->dropTable('{{%gallery}}');
    }

}
