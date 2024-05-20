<?php

namespace app\components\actions;

use Exception;
use Throwable;
use Yii;
use yii\base\ActionEvent;
use yii\web\Response;

class UpdateAction extends BaseAction
{
    // ВНИМАНИЕ!! Оба события инициируются внутри транзакции
    const EVENT_BEFORE_UPDATE = 'EVENT_BEFORE_UPDATE';
    const EVENT_AFTER_SUCCESSFUL_UPDATE = 'EVENT_AFTER_SUCCESSFUL_UPDATE';

    public string $defaultRedirectUrl = 'index';

    /**
     * @return array|bool[]|string|Response
     * @throws \Throwable
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $isAjax = Yii::$app->request->isAjax;

        try {
            $id = $this->getOrPostId();
            $model = $this->getModelById($id);

            if (!$isAjax) {
                BaseAction::rememberReferrerUrl();
            }

            if ($model->load(Yii::$app->request->post())) {
                // Начинаем транзакцию, инициируем EVENT_BEFORE_UPDATE
                $transaction = Yii::$app->db->beginTransaction();
                $event = new ActionEvent($this);
                $this->trigger(self::EVENT_BEFORE_UPDATE, $event);

                if (!$model->save()) {
                    $transaction->rollBack();
                } else {
                    // Инициируем EVENT_AFTER_SUCCESSFUL_UPDATE, завершаем транзакцию
                    $this->trigger(self::EVENT_AFTER_SUCCESSFUL_UPDATE, $event);
                    $transaction->commit();

                    if ($isAjax) {
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return $this->returnOnAjaxSuccess;
                    }

                    // Возвращаемся на ту же страницу паджинатора actionIndex если она есть.
                    return $this->controller->redirect(BaseAction::getRedirectUrl($this->defaultRedirectUrl));
                }
            }

            return $isAjax ? $this->controller->renderAjax($this->updateView, ['model' => $model])
                : $this->controller->render($this->updateView, ['model' => $model]);

        } catch (Throwable | Exception $e) {
            if (isset($transaction)) {
                $transaction->rollBack();
            }
            if ($isAjax) {
                return $this->controller->asJson(['result' => 'err', 'message' => $e->getMessage()]);
            }

            throw $e;
        }
    }
}