<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/*= $form->field($model, 'article_id')->dropDownList(
//        ArrayHelper::map($articles, 'id', 'title')
//    ) */
/* @var $this yii\web\View */
/* @var $model common\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textarea() ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map($categories, 'id', 'title')
    ) ?>

    <?= $form->field($model, 'old_dir_name')->hiddenInput(['value' => $model->dir_name])->label(false); ?>

    <?= $form->field($model, 'images[]')->fileInput(['multiple' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
