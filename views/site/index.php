<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

/*$this->registerJS(
	'$("document").ready(function(){
		$("#beschikbaar").on("pjax:end", function() {
			$.pjax.reload({container:"#binnenkortbeschikbaar"});
		});
	});'
);*/
/*
$this->registerJS(
	'$("document").ready(function(){
		setInterval(function(){ $("#binnenkortbeschikbaar").click();
		}, 3);
	});'
);*/

$script = <<< JS
$(document).ready(function() {
	setInterval(function(){ $("#beschikbaar").click();
}, 3000);
});
JS;
$this->registerJs($script);



/* @var $this yii\web\View */
$this->title = 'Glazenwassers';

?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Glazenwassers!</h1>
        <p class="lead">Wie lapt het meest en wie wordt er bij gelapt!</p>

		<?php
			echo Html::a("Refresh",
				['site/index', 'id' => 'beschikbaar'],
				['class' => 'btn btn-lg btn-primary']); ?>
        <!--<p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">

        <div class="row">

            <div class="col-lg-4"; align="center">
                <h2>Komen binnenkort beschikbaar</h2>
				<p>
				<?php
					Pjax::begin(['id' => 'beschikbaar']);
					/*echo Html::a("Refresh",
						['site/index', 'id' => 'beschikbaar'],
						['class' => 'btn btn-lg btn-primary']); */?>
					<?= ListView::widget( [
						'dataProvider' => $dataProviderStreet,
						'itemView' => '/streettransaction/_post',
					] );?>

				<? Pjax::end(); ?>    
				</p>
                <!--<p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>-->
            </div>
            <div class="col-lg-4"; align="center">
                <h2>Score</h2>

                <p>
				<?php
					Pjax::begin(['id' => 'beschikbaar']);
				/*	echo Html::a("Refresh",
						['site/index', 'id' => 'beschikbaar'],
						['class' => 'btn btn-lg btn-primary']);*/ ?>
					<?= ListView::widget( [
						'dataProvider' => $dataProviderScore,
						'itemView' => '/group/_post',
					] ); ?></p>
				<? Pjax::end(); ?>    
                <!--<p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>-->
            </div>
            <div class="col-lg-4"; align="center">
                <h2>Uitleg</h2>

                <p>Onder <b>"Komen binnenkort beschikbaar"</b> staan de straten die binnnen een minuut vrij komen.
					Let op: Een groep kan wel meer straten hebben, maar die zijn langer dan een minuut geldig.<br><br>
					Onder <b>"Score"</b> staat het vermogen van elke groep. <br><br>
					Druk op <b>"Refresh"</b> om de pagina te verversen en de laatste gegevens te bekijken.</p>

                <!--<p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>-->
            </div>
        </div>
	</div>
</div>
