<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\District;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StreetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Straten';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="street-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Straat Maken', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            [      
				'attribute'=>'district_id',
				'filter'=>District::getDistrictsArray(),
				'label'=>'Wijk',
				'format'=>'text',//raw, html
				'content'=>function($data){
					return $data->getDistrictName();
                }
			],
            'score',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
