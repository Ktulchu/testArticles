<?php

use yii\db\Migration;

/**
 * Class m240517_064454_createTableAutors
 */
class m240517_064454_createTableAutors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(500)->notNull(),
            'birthday' => $this->integer()->notNull(),
            'biography' => $this->text(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
