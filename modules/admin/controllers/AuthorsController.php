<?php

namespace app\modules\admin\controllers;

use app\models\autors\Authors;
use app\models\autors\AutorsSearch;

class AuthorsController extends BaseController
{
    protected $searchModelClass = AutorsSearch::class;
    protected $modelClass = Authors::class;
}