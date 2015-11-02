<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = "Dat mag dus niet2";
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-danger">
		<?= $form->errorSummary($model); ?>
        <?//= nl2br(Html::encode($message)) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <p>
        The above error occurred while the Web server was processing your request.
    </p>

</div>
