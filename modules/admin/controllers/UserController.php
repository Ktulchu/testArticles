<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\models\UserSearch;

class UserController extends BaseController
{
    protected $searchModelClass = UserSearch::class;
    protected $modelClass = User::class;
}