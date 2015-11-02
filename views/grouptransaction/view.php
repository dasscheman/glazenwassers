<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grouptransaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Groepsscore', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grouptransaction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Bijwerken', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Verwijderen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Weet je zeker dat je deze groepsscore wilt verwijderen?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'group_id',
			'status',
            'score',
        ],
    ]) ?>

</div>
