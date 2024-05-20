<?php

use app\models\category\Category;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

/** @var View $this */
/** @var Category $model */

$isUpdate = Yii::$app->controller->action->id == 'update';
$this->title = $isUpdate ? 'Категория: ' . $model->name : 'Новая категория';
$subTitle = $isUpdate ? 'Редактирования: ' : 'добавление';

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
        <?php $form = ActiveForm::begin(['id' => 'admin-form']);
        if ($model->getErrors()) : ?>
        <div class="alert alert-danger">
            <?= Html::errorSummary($model); ?>
        </div>
        <?php endif; ?>
        <div class="row mb-5">
            <div class="col-md-8">
                <?= $form->field($model, 'description')->widget(CKEditor::class,[
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder',['allowedContent' => true]),
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'parentId')->dropDownList(Category::getList(), ['prompt' => '']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>