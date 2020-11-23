<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
$this->title = $name;
?>
<div class="error-box">
    <div class="error-body text-center">
        <h1 class="text-danger"><?=$exception->statusCode?></h1>
        <h3><?= nl2br(Html::encode($message)) ?></h3>
        <p class="text-muted m-t-30 m-b-30"><?= Html::encode($this->title) ?></p>
        <a href="/" class="btn btn-danger btn-rounded m-b-40">Вернуться Домой</a> </div>
</div>





