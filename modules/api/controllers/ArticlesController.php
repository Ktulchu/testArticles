<?php

namespace app\modules\api\controllers;

use app\models\articles\Articles;
use app\models\articles\ArticlesSearch;

class ArticlesController extends BaseController
{
    protected $searchModelClass = ArticlesSearch::class;
    protected $modelClass = Articles::class;
}