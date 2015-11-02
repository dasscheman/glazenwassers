<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\Group;
use app\models\Street;

?>
<div class="post">
    <h4><?= HtmlPurifier::process($model->street->name)?> (<?= HtmlPurifier::process($model->district->name)?>)</h4>
    
    <?= Html::encode("Komt vrij op:") ?>    
	<?= Html::encode(date('Y-m-d H:i', strtotime("$model->end_datetime"))) ?> </br>

    <?= Html::encode("Huidige Bezitters:") ?>    
    <?= HtmlPurifier::process($model->group->name)?></br></br>
</div>
