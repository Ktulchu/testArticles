<?php

namespace app\models\articles;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\articles\Articles;

/**
 * ArticlesSearch represents the model behind the search form of `app\models\articles\Articles`.
 */
class ArticlesSearch extends Articles
{
    public array $withJoin = [];
    public $categoryId;
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'authorId', 'categoryId'], 'integer'],
            [['name', 'image', 'announcement', 'article'], 'safe'],
            ['with', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName
     * @return ActiveDataProvider
     */
    public function search(array $params, ?string $formName = null): ActiveDataProvider
    {
        $query = Articles::find();

        if (!empty($this->withJoin)) {
            foreach ($this->withJoin as $join) {
                $query = $query->joinWith($join);
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'articles.id' => $this->id,
            'authorId' => $this->authorId,
        ]);

        $query->andFilterWhere(['like', 'articles.name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'announcement', $this->announcement])
            ->andFilterWhere(['like', 'article', $this->article]);

       $query->andFilterWhere(['article_category.categoryId' => $this->categoryId]);

        return $dataProvider;
    }
}
