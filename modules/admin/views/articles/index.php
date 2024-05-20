<?php

use app\models\UserSearch;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\web\View;

/** @var View $this */
/** @var UserSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = 'Список статей';
$this->params['breadcrumbs'][] = ['label' => 'Администрирование', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Список</h3>
        <div class="btn-group">
            <?= Html::a('<span class="hidden-xs">Добавить </span> <i class="fa fa-plus"></i> ', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout'=>"{items}\n{pager}\n{summary}",
            'columns' => [
                [
                    'attribute'=>'id',
                    'headerOptions' => ['width' => '60'],
                ],
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Действия',
                    'headerOptions' => ['width' => '100'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function($url, $model) {
                            return Html::a('<i class="bi bi-pencil-fill"></i>', $url, ['class' => 'btn btn-sm btn-primary']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="bi bi-trash"></span>', $url, ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => 'Действие не обратимо. Вы уверены?']);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>