<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
$this->title = 'Spel Opzetten';


?>
<div class="site-index">  
	<table style="width:100%";>
		<tr>
			<td align="center";><h3>Groepen:</h3></td>
			<td align="center";><h3>Straten:</h3></td>		
			<td align="center";><h3>Wijken:</h3></td>
		</tr>
		<tr>
			<td align="center";><h4><?= Html::a('Groep Maken', ['/group/create'], ['class' => 'btn btn-success']) ?></h4></td>
			<td align="center";><h4><?= Html::a('Straat Maken', ['/street/create'], ['class' => 'btn btn-success']) ?></h4></td>		
			<td align="center";><h4><?= Html::a('Wijk Maken', ['/district/create'], ['class' => 'btn btn-success']) ?></h4></td>
		</tr>
		<tr>
			<td align="center";><h4><?= Html::a('Groepen Bekijken', ['/group/index'], ['class' => 'btn btn-success']) ?></h4></td>
			<td align="center";><h4><?= Html::a('Straten Bekijken', ['/street/index'], ['class' => 'btn btn-success']) ?></h4></td>		
			<td align="center";><h4><?= Html::a('Wijken Bekijken', ['/district/index'], ['class' => 'btn btn-success']) ?></h4></td>
		</tr>
		<tr>
			<td align="center"; style="width:30%; vertical-align:top";>
				<?= ListView::widget( [
					'dataProvider' => $dataProviderGroup,
					'itemView' => '/group/_post',
				] ); ?>
			</td>
			<td align="center"; style="width:30%; vertical-align:top";>
				<?= ListView::widget( [
					'dataProvider' => $dataProviderStreet,
					'itemView' => '/street/_post',
				] ); ?>
			</td>		
			<td align="center"; style="width:30%; vertical-align:top";>
				<?= ListView::widget( [
					'dataProvider' => $dataProviderDistrict,
					'itemView' => '/district/_post',
				] ); ?>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<p align="center">
	<?php if (Yii::$app->user->identity->username == 'admin'){ ?>
	<?= Html::a('Verwijder Alle Transactie', ['delete-game'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Weet je zeker dat je alle claimen en scores wilt verwijderen?
							  Dit kan niet meer ongedaan worden.',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Verwijder Volledig Spel', ['delete-all'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Weet je zeker dat je alle transacties wilt verwijderen?
							  Niet alleen alle claimen en scores worden verwijderd,
							  ook de groepen, wijken en straten.',
                'method' => 'post',
            ],
        ]);
	}?>

	</p>

</div>
