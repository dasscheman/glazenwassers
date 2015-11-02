<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Streettransaction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Straten Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->start_time;
?>
<div class="streettransaction-view">

    <h1><?= Html::encode($model->start_date) ?> - <?= Html::encode($model->start_time) ?></h1>

    <p>
        <?= Html::a('Bijwerken', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Verwijderen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Weet je zeker dat je deze claim wilt verwijderen?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [      
				'attribute'=>'street_id',
				'label'=>'Straatnaam',
				'format'=>'text',//raw, html
				'value'=>$model->getStreetName(),
			],
            [      
				'attribute'=>'group_id',
				'label'=>'Groep',
				'format'=>'text',//raw, html
				'value'=>$model->getGroupName(),
			],
            [      
				'attribute'=>'status',
				'label'=>'Status',
				'format'=>'text',//raw, html
				'value'=>$model->getStatusText(),
			],
            'start_datetime',
            'end_datetime',
        ],
    ]) ?>

</div>
