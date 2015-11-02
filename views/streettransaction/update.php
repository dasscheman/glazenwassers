<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Streettransaction */

$this->title = 'Claim Bijwerken: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Straten Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="streettransaction-update">

    <h1><?= Html::encode($model->start_time) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
