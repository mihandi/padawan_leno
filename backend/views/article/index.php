<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'label' =>'title',
                'contentOptions'=>['style'=>'white-space: normal;'] ,
                'value' => function ($model) {
                    return substr($model['title'],0,100);
                }
            ],
            [
                'label' =>'description',
                'contentOptions'=>['style'=>'white-space: normal;'] ,
                'value' => function ($model) {
                    return substr($model['description'],0,300);
                }
            ],
            [
                    'label' =>'content',
                'contentOptions'=>['style'=>'white-space: normal;'] ,
                'value' => function ($model) {
                    return substr($model['content'],0,300);
                    }
            ],
            [
                'format' => 'html',
                'label' => 'Image',
                'value' => function($data){
                    return Html::img($data->getMainImage($data,480,480), ['width'=>200]);
                }
            ],
//             'seo_url',
            // 'user_id',
            // 'status',
            // 'category_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>