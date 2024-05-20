<?php

namespace app\components\actions;

use Throwable;
use Yii;
use yii\base\ActionEvent;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\Response;

/**
 * ВНИМАНИЕ!! События BEFORE_CREATE и AFTER_SUCCESSFUL_CREATION инициируются внутри транзакции
 */
class CreateAction extends BaseAction
{
    const EVENT_BEFORE_CREATE = 'EVENT_BEFORE_CREATE';
    const EVENT_AFTER_SUCCESSFUL_CREATION = 'EVENT_AFTER_SUCCESSFUL_CREATION';
    const EVENT_BEFORE_RENDER = 'EVENT_BEFORE_RENDER';

    public string $defaultRedirectUrl = 'index';

    /**
     * @throws Throwable
     * @throws Exception
     */
    public function run()
    {
        try {
            $isAjax = Yii::$app->request->isAjax;
            $default_values = Yii::$app->request->get('default_values')
                ?? Yii::$app->request->post('default_values', []);

            /** @var $model ActiveRecord */
            $model = new $this->modelClass();
            $this->model = $model;
            $model->setAttributes($default_values);
            $event = new ActionEvent($this);
            if (!$isAjax) {
                BaseAction::rememberReferrerUrl();
            }

            if ($model->load(Yii::$app->request->post())) {
                // Начинаем транзакцию, инициируем EVENT_BEFORE_CREATE
                $transaction = Yii::$app->db->beginTransaction();
                $this->trigger(self::EVENT_BEFORE_CREATE, $event);

                if (!$model->save()) {
                    $transaction->rollBack();
                } else {
                    // Инициируем EVENT_AFTER_SUCCESSFUL_CREATION, завершаем транзакцию
                    $this->trigger(self::EVENT_AFTER_SUCCESSFUL_CREATION, $event);
                    $transaction->commit();

                    if ($isAjax) {
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return $this->returnOnAjaxSuccess;
                    }

                    // Возвращаемся на ту же страницу паджинатора actionIndex если она есть.
                    return $this->controller->redirect(BaseAction::getRedirectUrl($this->defaultRedirectUrl));
                }
            }

            $this->trigger(self::EVENT_BEFORE_RENDER, $event);
            return $isAjax ? $this->controller->renderAjax($this->updateView, ['model' => $model])
                : $this->controller->render($this->createView, ['model' => $model]);

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