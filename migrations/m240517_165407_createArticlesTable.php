<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articles}}`.
 */
class m240517_165407_createArticlesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull()->comment('Название'),
            'image' => $this->string(200)->notNull()->comment('Фото'),
            'announcement' => $this->string(1000)->comment('Анонс'),
            'article' => $this->text()->comment('Статья'),
            'authorId' => $this->integer()->notNull()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%articles}}');
    }
}
