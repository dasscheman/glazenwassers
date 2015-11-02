<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h4><?= Html::encode($model->name) ?></h4>
    
    <?= Html::encode("Bijbetaling voor een hele wijk (€):") ?>    
    <?= HtmlPurifier::process($model->score) ?>   
</div>