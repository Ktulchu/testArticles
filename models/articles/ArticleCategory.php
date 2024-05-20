<?php

namespace app\models\articles;

use app\models\category\Category;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "article_category".
 *
 * @property int $id
 * @property int $categoryId
 * @property int $articleId
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'article_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['categoryId', 'articleId'], 'required'],
            [['categoryId', 'articleId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'categoryId' => 'Категория',
            'articleId' => 'Статья',
        ];
    }

    /**********************************************************************************************************/
    /*                                Relation                                                                */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'categoryId']);
    }

    public function getArticle(): ActiveQuery
    {
        return $this->hasOne(Articles::class, ['id' => 'articleId']);
    }
}
