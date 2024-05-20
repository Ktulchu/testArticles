<?php

use app\models\autors\Authors;
use yii\bootstrap5\Html;
use yii\web\View;

/** @var View $this */
/** @var Authors $model */

$isUpdate = Yii::$app->controller->action->id == 'update';
$this->title = $isUpdate ? 'Автор: ' . $model->name : 'Новый автор';
$subTitle = $isUpdate ? 'Редактирования: ' : 'добавления';

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Форма <?= $subTitle; ?> </h3>
        <div class="btn-group">
            <?= Html::submitButton('Сохраниь',
                ['class' => 'btn btn-primary btn-sm', 'form' => 'admin-form']); ?>
            <?= Html::a('Отмена', ['index'],
                ['class' => 'btn btn-outline-secondary btn-sm']) ?>
        </div>
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
