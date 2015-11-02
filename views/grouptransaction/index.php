<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Grouptransaction;
use app\models\Group;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GrouptransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groepsscores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grouptransaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<? 	echo
		Highcharts::widget([
			'options' => [
				'chart' => [
					'type' => 'spline'],
				'title' => [
					'text' => 'Groepsscore'],
				'subtitle' => [
					'text' => 'wie heeft het meest gelapt!'],
				'xAxis' => [
					'type' => 'datetime',
					'dateTimeLabelFormats' => [
						'hour'=> '%A %H:%M',
						'day'=>'%A %e %b',
						'week'=>'%A %e %b',],
					'title' => [
						'text' => 'Tijd']],
				'yAxis' => [
					'title' => [
						'text' => 'Score'],],
					//'min' => 0],
				'tooltip' => [
					'headerFormat' => '<b>{series.name}</b><br>',
					'pointFormat' => 'Claim om: {point.x:%H:%M} (hh:mm) {point.y:.2f} punten'],
				'plotOptions' => [
					'spline' => [
						'marker' => [
							'enabled' => true]]],
				'series' => $graphData,]
		]); ?>




    <p>
        <?//= Html::a('Groepsscore Toevoegen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'showOnEmpty' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
			[      
				'attribute'=>'street_transaction_id',
				//'filter'=>Group::getGroupsArray(),
				'label'=>'Straat Claim',
				'format' => 'raw',
				'value'=>function ($data) {
					return Html::a(	Html::encode("Bekijk Straat Claim"),
									[	'streettransaction/view',
										'id' => $data->street_transaction_id]);
                }
			],
			[      
				'attribute'=>'group_id',
				'filter'=>Group::getGroupsArray(),
				'label'=>'Groep',
				'format'=>'text',//raw, html
				'content'=>function($data){
					return $data->getGroupName();
                }
			],
			[      
				'attribute'=>'status',
				'filter'=>Grouptransaction::getStatusOptions(),
				'label'=>'Status',
				'format'=>'text',//raw, html
				'content'=>function($data){
					return $data->getStatusText();
                }
			],
            'score',
			'datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
