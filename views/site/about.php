<?php
use yii\helpers\Html;
use cics\widgets\VideoEmbed;

/* @var $this yii\web\View */
$this->title = 'Wat is Glazenwasser?';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <div class="body-content">
	
		<div class="col-lg-12">
			<h4>Kopje koffie glazenwasser?</h4>
			<p>
				Glazenwasser, het lijkt een onschuldige beroepsgroep.
				Maar niets blijkt minder waar.
				Er regeert een ware glazenwassers maffia in Nederland en in deze branche gaan jullie je begeven. 
				Wil je weten wat voor risico's jullie lopen, dan kan je de filmpjes bekijken. </br></br>
				
				Jullie hebben een lijst met straten en objecten gekregen.
				Jullie moeten de ramen van de huizen in deze straten of van deze object gaan "wassen".
				Als bewijs dat jullie de ramen hebben gewassen maken jullie een foto van het straatnaambordje
				of naambordje van het object met jullie groepje. 
				Deze foto stuur je naar de organisatie.</br>
				Als deze straat / object nog niet gewassen is door een andere groep,
				dan krijgen jullie geld voor het werk (prijs staat op de straatnaamlijst).
				Deze straat of object is nu ook voor 15 minuten jullie grondgebied. 
				Als in die 15 minuten een andere groep jullie straat probeert te "wasssen" dan moet die groep
				jullie betalen (dezelde prijs als een straat opleverd).
				Als jullie alle straten / objecten uit een wijk hebben dan krijgen jullie een bonus
				(de andere groep betaald die bonus). </br></br>
		
				Na 15 minuten verloopt jullie recht op de straat of object.
				Jullie kunnen de straat weer opnieuw "wassen" (je kunt dezelfde foto als bewijs gebruiken).
				Dit kan alleen als jullie een nieuwe wasbeurt (een straat of object die jullie niet eerder gewassen hebben)
				hebben uitgevoerd voordat jullie een oude wasbeurt uitvoeren.

				Als jullie laatste wasbeurt niet nieuw was, dan krijg je een boete.</br></br>
		
				Als je een straat wast waar jullie het recht nog van hebben, dan krijg je ook een boete;
				Je bent te vroeg met een wasbeurt en dat wordt niet gewaardeerd.
			
				Voorwaarde voor de bewijsfoto:
				De naam van de straat of object moet duidelijk leesbaar zijn.
				Het hele groepje, min de fotograaf, moet herkenbaar op de foto staan! </br></br>

				Op de beginpagina van deze site vind je de status van het spel. Onder "Score" staat het
				vermogen van elke groep. Onder "Komen binnenkort beschikbaar" staan de straten die binnen een minuut vrij
				komen.
				Let op: Een groep kan wel meer straten hebben, maar die zijn langer dan een minuut geldig.
				Gebruik de op "Refresh" knop om de pagina te verversen en de laatste gegevens te bekijken</p>
	
			<!--<p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>-->
		</div>
        <div class="row">
            <div class="col-lg-5"; align="center">
                <h2>Rambam deel 1</h2>

                <p>
					<?= $video = VideoEmbed::widget(['url' => 'https://www.youtube.com/watch?v=ygKxWKibWyE']); ?>
				</p>
                <!--<p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>-->
            </div>
           <div class="col-lg-2"; align="center">
				<h2></h2>
				<p></p>

		<!--<p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>-->
			</div>
            <div class="col-lg-5"; align="center">
                <h2>Rambam deel 2</h2>

				<?= VideoEmbed::widget(['url' => 'https://www.youtube.com/watch?v=86N0tA9tJys']); ?>

                <!--<p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>-->
            </div>
        </div>
	</div>
</div>
