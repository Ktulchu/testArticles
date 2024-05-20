<?php

namespace app\components\actions;

use Yii;
use yii\web\NotFoundHttpException;

class ViewAction extends BaseAction
{
    /**
     * @return string
     * @throws \Throwable
     * @throws NotFoundHttpException
     */
    public function run(): string
    {
        $id = $this->getOrPostId();
        $model = $this->getModelById($id);

        return $this->controller->render($this->viewView, ['model' => $model]);
    }
}