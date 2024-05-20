<?php

namespace app\modules\api\controllers;

use app\models\autors\Authors;
use app\models\autors\AutorsSearch;

class AuthorController extends BaseController
{
    protected $searchModelClass = AutorsSearch::class;
    protected $modelClass = Authors::class;
}