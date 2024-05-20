<?php

namespace app\components\actions;

use Yii;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class BaseAction
 * @package app\components\actions
 *
 * Базовый класс для стандартных экшенов Index, View, Update, Create, Delete
 * Используется для работы с одной моделью
 */
class BaseAction extends Action
{
    /** @var string Имя класса get_class() модели
     * для которой вызываются actionIndex, view, create, update, delete
     */
    public $modelClass;

    /**
     * @var ActiveRecord Модель обрабатываемая в actionCreate, update, delete.
     * Св-во используется для образования связи
     * экшена и модели, чтобы в обработчиках событий была возможность обращаться к $event->sender->model
     */
    public $model;

    /** @var string Имя класса get_class(), м
     * одели, которая используется как $search_model в actionIndex
     */
    public $searchModelClass;

    /** @var string Имена вьюх для actionIndex, view, create, update */
    public $indexView = 'index';
    public $viewView = 'view';
    public $createView = 'update_create';
    public $updateView = 'update_create';

    /*********************************************************************************************************
     *                                  PROTECTED  FUNCTIONS
     *
     * @param int $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    protected function getModelById(int $id): ActiveRecord
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        if (is_null($model = $modelClass::findOne($id))) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }

    /** @return mixed */
    protected function getOrPostId()
    {
        return Yii::$app->request->get('id') ?? Yii::$app->request->post('id');
    }

    /*********************************************************************************************************
     *                                      STATIC  FUNCTIONS
     * * @return void
     */
    public static function rememberReferrerUrl(): void
    {
        $key = Yii::$app->controller->route;
        $referrerUrl = Yii::$app->request->referrer;

        if (strpos($referrerUrl, $key) === false) {
            Yii::$app->session->set($key, $referrerUrl);
        }
    }

    /**
     * @param string|string[]|null $defaultUrl
     * @return mixed|string|string[]
     */
    public static function getRedirectUrl($defaultUrl = null)
    {
        $key = Yii::$app->controller->route;
        return Yii::$app->session->remove($key) ?? $defaultUrl ?? ['index'];
    }
}