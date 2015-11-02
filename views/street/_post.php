<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\Group;
use app\models\Street;

?>
<div class="post">
    <h4><?= Html::encode($model->name) ?></h4>
    
    <?= Html::encode("Straatnaam:") ?>    

    <?= HtmlPurifier::process($model->name)?> </br>      
    <?= Html::encode("Prijs (€):") ?>    
    <?= HtmlPurifier::process($model->score)?>
</div>