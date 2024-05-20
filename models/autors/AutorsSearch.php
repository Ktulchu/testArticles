<?php

namespace app\models\autors;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\autors\Authors;

/**
 * AutorsSearch represents the model behind the search form of `app\models\autors\Authors`.
 */
class AutorsSearch extends Authors
{
    public array $withJoin = [];
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'birthday'], 'integer'],
            [['name', 'biography'], 'safe'],
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
    public function search(array $params): ActiveDataProvider
    {
        $query = Authors::find();

        if (!empty($this->withJoin)) {
            foreach ($this->withJoin as $join) {
                $query = $query->joinWith($join);
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'authors.id' => $this->id,
            'birthday' => $this->birthday,
        ]);

        $query->andFilterWhere(['like', 'authors.name', $this->name]);

        return $dataProvider;
    }
}
