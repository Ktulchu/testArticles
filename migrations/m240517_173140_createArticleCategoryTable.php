<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_category}}`.
 */
class m240517_173140_createArticleCategoryTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
            'categoryId' => $this->integer()->notNull(),
            'articleId' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_category}}');
    }
}
