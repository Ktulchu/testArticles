<?php

use app\components\Image;
use app\models\articles\Articles;
use app\models\autors\Authors;
use app\models\category\Category;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var Articles $model */

?>
<?php $form = ActiveForm::begin(['id' => 'admin-form']);
if ($model->getErrors()) : ?>
    <div class="alert alert-danger">
        <?= Html::errorSummary($model); ?>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col-lg-8">
            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'announcement')->widget(CKEditor::class, [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['allowedContent' => true]),
            ]); ?>
            <?= $form->field($model, 'article')->widget(CKEditor::class, [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['allowedContent' => true]),
            ]); ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'authorId')->dropDownList(Authors::getList(), ['prompt' => '']) ?>

            <div class="upload mb-3">
                <span class="btn btn-danger del-image"><i class="bi bi-trash"></i></span>
                <img id="main-image" class="w-100" src="<?= Image::resize($model->image, 517, 169); ?>" alt=""/>
                <?= $form->field($model, 'image')->widget(InputFile::class, [
                    'language' => 'ru',
                    'controller' => 'elfinder',
                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control js-upload', 'data-id' => 'main-image', 'data-size' => '240', 'readonly' => true],
                    'buttonOptions' => ['class' => 'btn btn-outline-secondary btn-main-image', 'style' => 'height: 37px;'],
                    'multiple' => false,
                    'path' => '/article'
                ]); ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Категории</label>
                <?= Html::dropDownList('categories', null, Category::getList(),
                    ['prompt' => '', 'class' => 'form-select', 'id' => 'category']); ?>
            </div>
            <div id="scrollbar" class="scrolbox card">
                <?php if ($model->categories) : ?>
                    <?php foreach($model->categories as $category) :?>
                        <div>
                            <i class="bi bi-x-circle-fill"></i>
                            <?= Html::hiddenInput('ArticleCategory[categoryId][]', $category->categoryId); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
$defaultImage = Image::resize('nofoto.jpg', 517, 169);
$script = <<<JS
 // Открываем файловый менеджер по клику на изображение
    $('#main-image').on('click', function (){
        $('#articles-image_button').trigger('click');
    });

    $('#articles-image_button').text('Обзор');
    
    // при изменении поля подгружаем картинку 
    $(document).on('change', '.js-upload', function() {
	    const elementImage = $('#' + $(this).data('id'));
        const elementInput = $(this);
        console.log(elementImage.length);
        $.ajax({
            url: '/admin/auxx/image-resize',
            data: {imagePath : $(this).val(), size_w : 517, size_h : 169},
            dataType: 'json',
            success: function(json) {		
                elementImage.attr('src', json);
                let newString = elementInput.val().replace("/images/", "");
                elementInput.val(newString);
            }
        });
    });
    
    $('.del-image').on('click', function () {
        $('#category-image').val('');
        $('#main-image').attr('src', '$defaultImage');
    });
    
    $('#category').on('change', function (){
        var key = $(this).val();
	    var text = $("#category option:selected").text();
        $('#scrollbar').append('<div><i class="bi bi-x-circle-fill"></i> '+ text +' <input type="hidden" name="ArticleCategory[categoryId][]" value="'+ key +'"></div>');
        $(this).val(null);
    });
    
    $(document).on("click",'.bi-x-circle-fill', function () {
       $(this).parent("div").remove(); 
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);