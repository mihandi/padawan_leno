<?php
/*
SELECT id,title,
month(FROM_UNIXTIME(created_at,"%Y-%m-%d")) as 'month',
year(FROM_UNIXTIME(created_at,"%Y-%m-%d")) as 'year'
FROM `article`

возвращает номер месяца
*/

function getMonthName($id){
    $month_name[1] = 'Січень';
    $month_name[2] = 'Лютий';
    $month_name[3] = 'Березень';
    $month_name[4] = 'Квітень';
    $month_name[5] = 'Травень';
    $month_name[6] = 'Червень';
    $month_name[7] = 'Липень';
    $month_name[8] = 'Серпень';
    $month_name[9] = 'Вересень';
    $month_name[10] = 'Жовтень';
    $month_name[11] = 'Листопад';
    $month_name[12] = 'Грудень';
    return $month_name[$id];

}
?>

<div class="list-widget archive-widget m-b-60">
    <h4 class="lw-title">АРХІВ</h4>
    <ul class="lw-list-two v-list">
        <?php foreach ($months as $month): ?>
            <li>
                <a href="/blog/archive?month=<?= $month['month']?>">
                    <span class="date"><?= getMonthName($month['month'])?> 2018</span>
                    <span class="totals"><?= $month['count']?></span>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
</div>
