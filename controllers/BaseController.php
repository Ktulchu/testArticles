<?php

namespace app\controllers;

use app\components\actions\IndexAction;
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
                'class' => [
                    'class' => IndexAction::class,
                    'searchModelClass' =>  $this->searchModelClass,
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass
            ]
        ];
    }
}