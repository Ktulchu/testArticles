<?php

namespace app\models\articles;

use app\components\behaviors\ImageResizeBehavior;
use app\models\autors\Authors;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $name Название
 * @property string $image Фото
 * @property string|null $announcement Анонс
 * @property string|null $article Статья
 * @property int $authorId
 *
 * @property ArticleCategory[] $categories
 */
class Articles extends ActiveRecord
{
    const CAPTION_SIZE_WIDTH = 200;
    const CAPTION_SIZE_HEIGHT =200;

    public string $caption;

    public function behaviors(): array
    {
        return [
            ImageResizeBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'image', 'authorId'], 'required'],
            [['article'], 'string'],
            [['authorId'], 'integer'],
            [['name', 'image'], 'string', 'max' => 200],
            [['announcement'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'image' => 'Изображение',
            'announcement' => 'Анонс',
            'article' => 'Статья',
            'authorId' => 'Автор',
        ];
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(ArticleCategory::class, ['articleId' => 'id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Authors::class, ['id' => 'authorId']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['caption'] = function ($model) {
            return $model->caption;
        };
        return $fields;
    }

    /**********************************************************************************************************/
    /*                                 EVENTS                                                                 */
    /**
     * @throws Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            ArticleCategory::deleteAll(['articleId' => $this->id]);

            $articleCategories = [];
            foreach ($_POST['ArticleCategory']['categoryId'] as $categoryId) {
                $articleCategories[] = [$this->id, $categoryId];
            }

            Yii::$app->db->createCommand()
                ->batchInsert(ArticleCategory::tableName(), ['articleId', 'categoryId'], $articleCategories)
                ->execute();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new Exception('Ошибка обновления принадлежности категориям: ' . $e->getMessage());
        }
    }
}
