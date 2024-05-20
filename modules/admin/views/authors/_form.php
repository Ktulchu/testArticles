<?php

use app\models\autors\Authors;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use mihaildev\elfinder\ElFinder;
use yii\jui\DatePicker;

/** @var Authors $model */

$form = ActiveForm::begin(['id' => 'admin-form']);
    if ($model->getErrors()) : ?>
    <div class="alert alert-danger">
        <?= Html::errorSummary($model); ?>
    </div>
    <?php endif; ?>
<div class="row mb-5">
    <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'birthday')->widget(DatePicker::class, [
            'dateFormat' => 'dd.MM.yyyy',
            'options' => ['class' => 'form-control'],
        ]) ?>
    </div>
    <div class="col-12">
       <?= $form->field($model, 'biography')->widget(CKEditor::class,[
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',['allowedContent' => true]),
        ]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
