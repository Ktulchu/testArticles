<?php

namespace app\modules\admin\controllers;

use app\components\Image;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class AuxxController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'ajax-action' => ['POST', 'GET'],
                ],
            ],
        ];
    }


    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * ResizeImage an existing Image model.
     * @param string $imagePath
     * @param integer $size_w
     * @param integer $size_h
     * @return string json
     * @throws Exception
     */
    public function actionImageResize(string $imagePath, int $size_w, int $size_h): string
    {
        $array = explode('.', $imagePath);
        if ($array[1] == 'svg') return $imagePath;

        return Image::resize(str_replace('/images/', '', $imagePath), $size_w, $size_h);
    }
}