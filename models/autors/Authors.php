<?php

namespace app\models\autors;

use app\models\articles\Articles;
use app\models\CommonArModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $name
 * @property int $birthday
 * @property string|null $biography
 *
 * @property Articles $articles
 */
class Authors extends CommonArModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'birthday'], 'required'],
            [['birthday'], 'match', 'pattern' => '/^\d{2}\.\d{2}\.\d{4}$/',
                'message' => 'Дата рождения должна быть в формате dd.mm.YYYY'],
            [['name'], 'string', 'max' => 500],
            [['biography'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'birthday' => 'Год рождения',
            'biography' => 'Биография',
        ];
    }

    /**********************************************************************************************************/
    /*                                Relation                                                                */
    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(Articles::class, ['authorId' => 'id']);
    }

    /**********************************************************************************************************/
    /*                                 EVENTS                                                                 */
    public function beforeSave($insert): bool
    {
        if (!is_int($this->birthday)) $this->birthday = strtotime($this->birthday);
        return parent::beforeSave($insert);
    }


}
