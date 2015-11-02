<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'members')->textInput(['maxlength' => 255]) ?> 
    <?= $form->field($model, 'start_score')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Opslaan' : 'Opslaan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
