<?php

/* @var $this yii\web\View */

$this->title = 'Frontend';

?>
<style>
    #rock {
        width: 150px;
        height: 150px;
        background-image: url();
        background-repeat: no-repeat;
    }
</style>
<div class="site-index">

    <div class="jumbotron">
        <h1>PadaWan!</h1>

        <p class="lead">Зайди в админку и посмотри миграции для таблиц Article и Category.</p>
        <p class="lead">Запусти yii migrate/fresh. Просмотри модели, потом по ним нужно будет строить Sql запросы.
            Удачи!
        </p>

        <p>
            <a  href="<?= Yii::getAlias('@backendBaseUrl')?>">
                <img width="300px" height="300px" src="https://n1s2.starhit.ru/93/4d/f1/934df1d2dec960cbfc0234552d0a962c/480x497_0_b119ac0c203b092f6a77ba6f6154219f@480x497_0xc0a8399a_5726684191492074702.jpeg">
                    <span style="display: block;">
                        Заценить!
                    </span>
                </img>
            </a>
        </p>
    </div>
</div>
