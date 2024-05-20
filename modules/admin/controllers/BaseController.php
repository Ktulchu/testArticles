<?php

namespace app\modules\admin\controllers;

use app\components\actions\CreateAction;
use app\components\actions\DeleteAction;
use app\components\actions\IndexAction;
use app\components\actions\UpdateAction;
use app\components\actions\ViewAction;
use yii\web\Controller;

class BaseController extends Controller
{
    protected $searchModelClass;
    protected $modelClass;
    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'searchModelClass' =>  $this->searchModelClass,
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass
            ],
            'update' => [
                'class' => UpdateAction::class,
                'modelClass' => $this->modelClass
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => $this->modelClass
            ],
        ];
    }
}