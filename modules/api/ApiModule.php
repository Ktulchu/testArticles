<?php

namespace app\modules\api;

use yii\base\Module;
use yii\web\IdentityInterface;

/**
 * api module definition class
 */
class ApiModule extends Module
{
    /**
     * Функция авторизации пользователя
     * function ($login, $password): \yii\web\IdentityInterface|null
     *
     * @var \Closure
     */
    public $auth;

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @param $login
     * @param $password
     * @return null|IdentityInterface
     */
    public function auth($login, $password): ?IdentityInterface
    {
        /**
         * @var $class IdentityInterface
         * @var IdentityInterface $user
         */
        $class = \Yii::$app->user->identityClass;
        if (method_exists($class, 'findByUsername')) {
            $user = $class::findByUsername($login);
            if ($user && method_exists($user, 'validatePassword') && $user->validatePassword($password)) {
                return $user;
            }
        }
        return null;
    }
}
