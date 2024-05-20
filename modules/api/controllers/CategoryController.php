<?php

namespace app\modules\api\controllers;

use app\models\category\Category;
use app\models\category\CategorySearch;

class CategoryController extends BaseController
{
    protected $searchModelClass = CategorySearch::class;
    protected $modelClass = Category::class;

    public function actionTree(): array
    {
        $model = new Category();
        return array_values($model->getTree());
    }
}