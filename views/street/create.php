<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Street */

$this->title = 'Straat Maken';
$this->params['breadcrumbs'][] = ['label' => 'Straten', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="street-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
