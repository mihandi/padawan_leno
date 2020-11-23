<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */

use budyaga\cropper\Widget;

$route = "/gallery/set-image?id=".$gallery_id;
?>

<a class="btn btn-default" href="<?= Url::to(['/gallery/view','id'=> $gallery_id])?>">Return</a>

<a class="btn btn-success" href="<?= Url::to(['/gallery/view','id'=> $gallery_id,'saveImage' => 1])?>">Save Image</a>



<?php $form = ActiveForm::begin(['id' => 'form-profile']); ?>
<?php echo $form->field($model, 'image')->widget(Widget::className(), [
    'uploadUrl' => Url::toRoute($route),
    'width' => 1000,
    'height' => 1000    ,
]) ?>
<?php ActiveForm::end(); ?>


