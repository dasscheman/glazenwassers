<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Streettransaction */

$this->title = 'Nieuwe ramen wassen';
$this->params['breadcrumbs'][] = ['label' => 'Straten Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="streettransaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
