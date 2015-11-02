<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Grouptransaction */

$this->title = 'Groepsscore Toevoegen';
$this->params['breadcrumbs'][] = ['label' => 'Groepsscores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grouptransaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
