<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Street;
use app\models\Streettransaction;
use app\models\District;
use app\models\Group;

use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use yii\web\JsExpression;

// Aanpassing in tijd ofset voor in de grafiek
$setupOptions = ['global' => ['timezoneOffset' => - 60000 ]];

/* @var $this yii\web\View */
/* @var $searchModel app\models\StreettransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$categorien = Street::getStreetsArrayNoKey();
$streetModel = new Street;
$categorien =  $streetModel->getStreetsArrayNoKey();
$data = $streetModel->getDataArrayForGraph();
/*
echo '<pre>';
print_r($data);
echo '</pre>';*/
//exit;
$this->title = 'Glazen wassen';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="streettransaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<? 	echo
		Highcharts::widget([
				'scripts' => [
					'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
					'modules/exporting', // adds Exporting button/menu to chart
					'themes/grid'        // applies global 'grid' theme to all charts
				],
				'options' => [
					'chart' => [
						'type'=> 'columnrange',
						'inverted' => true],
					'title' => [
						'text' => 'Geclaimde straten'],	
					'subtitle' => [
						'text' => 'Overzict van straten die geclaimed zijn'],
					'xAxis' => [
						'categories' => $categorien],
					'yAxis' => [
						'type' => 'datetime',
						'dateTimeLabelFormats' => [
							'hour'=> '%A %H:%M',
							'day'=>'%A %e %b',
							'week'=>'%A %e %b',],
						'title' => [
							'text' => 'Tijd ( hh:mm )']],
					'tooltip' => [
						'headerFormat'=>'<b>{series.name}</b><br>',
						'pointFormat'=>'Geclaimed tussen: {point.low:%H:%M} - {point.high:%H:%M}',
						'valueSuffix' => '( hh:mm )'],
					'plotOptions' => [
						'columnrange' => [
							'grouping' => true,
							'dataLabels' => [
								'enabled' => false,
							]
						]
					],
					/*'plotOptions' => [
						'columnrange' => [
							'dataLabels' => [
								'enabled' => true,
								'formatter' => function () {
									return this.y + '°C';}]]],*/
					'legend' => [
						'enabled' => true],
					'series' => $data,
				]
			]);

		?>
    <p>
        <?= Html::a('Nieuwe ramen wassen', ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('Alle transacties updaten', ['update-all'], ['class' => 'btn btn-primary']) ?>
	</p>
<?php

 ?>   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'showOnEmpty' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
			[
				'attribute' => 'street',
				'value' => 'street.name'	
			],	
			[
				'attribute' => 'district',
				'value' => 'district.name'	
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
				'filter'=>Streettransaction::getStatusOptions(),
				'label'=>'Status',
				'format'=>'text',//raw, html
				'content'=>function($data){
					return $data->getStatusText();
                }
			],
            'start_datetime',
            'end_datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
