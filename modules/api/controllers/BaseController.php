<?php

namespace app\modules\api\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    protected $modelClass;
    protected $searchModelClass;

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ]);
    }

    public function actionIndex(array $union = []): array
    {
        $searchModel = new $this->searchModelClass([
            'withJoin' => $union
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '');

        $models = $dataProvider->getModels();
        $result = [];
        if ($models) {
            foreach ($models as $model) {
                $result[] = $this->convertModelToArrayWithRelations($model, $union);
            }
        }

        return $result;
    }

    public function actionView(int $id, array $union = [])
    {
        $query = $this->modelClass::find()
            ->with($union)
            ->where([$this->modelClass::tableName() . '.id' => $id]);

        $model = $query->one();

        return $this->convertModelToArrayWithRelations($model, $union);
    }

    private function convertModelToArrayWithRelations ($model, $union)
    {
        $result = $model->toArray();
        if (!empty($union)) {
            foreach ($union as $relation) {
                $result[$relation] = $model->$relation;
            }
        }
        return $result;
    }
}
