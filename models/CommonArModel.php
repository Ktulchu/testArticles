<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class CommonArModel extends ActiveRecord
{
    public string $titleField = 'name';

    public static function getList(string $titleField = 'name', $filter = []): array
    {
        $query = static::find()
            ->select(['id', $titleField]);
        if (!empty($filter)) {
            $query->where($filter);
        }
        $models = $query->all();

        return ArrayHelper::map($models, 'id', $titleField);
    }
}