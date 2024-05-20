<?php

namespace app\modules\admin\controllers;

use app\models\articles\Articles;
use app\models\articles\ArticlesSearch;

class ArticlesController extends BaseController
{
    protected $searchModelClass = ArticlesSearch::class;
    protected $modelClass = Articles::class;
}