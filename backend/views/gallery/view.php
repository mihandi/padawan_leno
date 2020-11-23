<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Galleries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Set Image', ['set-image', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php $path_to_folder = '/gallery/'.$model->dir_name;?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title:ntext',
            'category_id',
            'article_id',
            'seo_url:ntext',
            'dir_name:ntext',
        ],
    ]) ?>

</div>
