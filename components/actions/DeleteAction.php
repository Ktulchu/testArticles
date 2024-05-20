<?php

namespace app\components\actions;

use Exception;
use Throwable;
use Yii;
use yii\base\ActionEvent;

class DeleteAction extends BaseAction
{
    // ВНИМАНИЕ!! Оба события инициируются внутри транзакции
    const EVENT_BEFORE_DELETE = 'EVENT_BEFORE_DELETE';
    const EVENT_AFTER_SUCCESSFUL_DELETION = 'EVENT_AFTER_SUCCESSFUL_DELETION';

    public $defaultRedirectUrl = 'index';

    /**
     * @return \yii\web\Response
     * @throws Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        try {
            $isAjax = Yii::$app->request->isAjax;
            $id = $this->getOrPostId();
            $model = $this->getModelById($id);

            // Начинаем транзакцию, инициируем EVENT_BEFORE_DELETE
            $transaction = Yii::$app->db->beginTransaction();
            $event = new ActionEvent($this);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);

            $model->delete();

            // Инициируем EVENT_AFTER_SUCCESSFUL_DELETION, завершаем транзакцию
            $this->trigger(self::EVENT_AFTER_SUCCESSFUL_DELETION, $event);
            $transaction->commit();

            if ($isAjax) {
                return $this->controller->asJson(['result' => 'ok']);
            }

            // Возвращаемся на ту же страницу паджинатора actionIndex если она есть.
            return $this->controller->redirect(BaseAction::getRedirectUrl($this->defaultRedirectUrl));

        } catch (Throwable | Exception $e) {
            if (isset($transaction)) {
                $transaction->rollBack();
            }
            throw $e;
        }
    }
}