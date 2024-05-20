<?php

namespace app\models\category;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\category\Category;

/**
 * CategorySearch represents the model behind the search form of `app\models\category\Category`.
 */
class CategorySearch extends Category
{
    public array $withJoin = [];
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'parentId'], 'integer'],
            [['name', 'description'], 'safe'],
            ['withJoin', 'safe']
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
     *
     * @return ActiveDataProvider
     */
    public function search(array $params, ?string $formName = null): ActiveDataProvider
    {
        $query = Category::find();

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
            'id' => $this->id,
            'parentId' => $this->parentId,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
