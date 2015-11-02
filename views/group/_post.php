<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h4><?= Html::encode($model->name) ?></h4>
        
    <?= Html::encode("Leden:") ?>   
    <?= HtmlPurifier::process($model->members) ?> </br>
    <?= Html::encode("Vermogen (€):") ?>   
    <?= HtmlPurifier::process($model->getGroupScore()) ?>  </br> </br>
</div>
