<?php

namespace app\modules\admin\controllers;

use app\models\category\Category;
use app\models\category\CategorySearch;

class CategoryController extends BaseController
{
    protected $searchModelClass = CategorySearch::class;
    protected $modelClass = Category::class;
}