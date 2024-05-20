<?php

namespace app\components\actions;

use Yii;
use yii\base\ActionEvent;
use yii\helpers\Url;

class IndexAction extends BaseAction
{
    /** Для обращения к $dataProvider в событии EVENT_BEFORE_RENDER */
    const EVENT_BEFORE_RENDER = 'EVENT_BEFORE_RENDER';

    public $dataProvider;
    public array $preFilter = [];

    public function run(): string
    {
        $searchModel = new $this->searchModelClass($this->preFilter);

        $this->dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $event = new ActionEvent($this);
        $this->trigger(self::EVENT_BEFORE_RENDER, $event);

        Url::remember(Url::current(), 'relatedActionIndexUrl');

        return $this->controller->render($this->indexView, [
            'searchModel' => $searchModel,
            'dataProvider' => $this->dataProvider,
        ]);
    }
}