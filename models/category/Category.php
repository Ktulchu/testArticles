<?php

namespace app\models\category;

use app\models\articles\ArticleCategory;
use app\models\articles\Articles;
use app\models\articles\ArticlesSearch;
use app\models\CommonArModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $parentId
 */
class Category extends CommonArModel
{
    const EXTRA_FIELD = [
        'caption' => 'caption'
    ];

    protected array $data = [];
    public $caption;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 250],
            [['description'], 'string'],
            ['parentId', 'exist', 'targetClass' => self::class, 'targetAttribute' => 'id'],
            ['parentId', 'compare', 'compareAttribute' => 'id', 'operator' => '!=', 'message' => 'Категория не может ссылаться на себя'],

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
            'description' => 'Описание',
            'parentId'  => 'Родительская категория'
        ];
    }

    /**********************************************************************************************************/
    /*                                EVENTS                                                                */

    /**********************************************************************************************************/
    /*                                Relation                                                                */
    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(ArticleCategory::class, ['categoryId' => 'id'])
            ->leftJoin(Articles::tableName() .' a', 'a.id = article_category.articleId');
    }

    /**********************************************************************************************************/
    /*                                Public                                                                  */
    public function getTree(): array
    {
        $this->data = static::find()
            ->select([
                'id',
                'parentId',
                'name',
            ])
            ->orderBy(['name' => SORT_ASC])
            ->indexBy('id')
            ->asArray()
            ->all();

        return $this->recursiveTreeData();
    }

    private function recursiveTreeData(): array
    {
        $tree = [];
        foreach ($this->data as $id => &$node)
        {
            if(!$node['parentId']) {
                $tree[$id] = &$node;
            } else {
                $this->data[$node['parentId']]['childish'][$node['id']] = &$node;
            }
        }

        return $tree;
    }
}
