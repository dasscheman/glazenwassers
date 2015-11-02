<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\District */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Wijken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Bijwerken', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Verwijderen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Weet je zeker dat je deze wijk wilt verwijderen?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'score',
        ],
    ]) ?>

</div>
