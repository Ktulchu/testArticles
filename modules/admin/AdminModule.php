<?php

namespace app\modules\admin;

use app\models\User;
use app\modules\admin\assets\AdminAsset;
use Yii;
use yii\base\InvalidRouteException;
use yii\base\Module;

/**
 * admin module definition class
 */
class AdminModule extends Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = '@app/modules/admin/views/layouts/main';

    /**
     * @throws InvalidRouteException
     */
    public function beforeAction($action): bool
    {
        if (Yii::$app->user->isGuest || !User::isUserActive(Yii::$app->user->id)) {
            Yii::$app->getResponse()->redirect(['/site/login']);
            return false;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        AdminAsset::register(Yii::$app->view);
    }
}
