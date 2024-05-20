<?php

use yii\db\Migration;

/**
 * Class m240517_175653_addFkArticle
 */
class m240517_175653_addFkArticle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-article_category-articleId-articles-id',
            'article_category',
            'articleId',
            'articles',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-article_category-articleId-articles-id',
            'article_category'
        );
    }
}
