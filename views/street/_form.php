<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\District;

/* @var $this yii\web\View */
/* @var $model app\models\Street */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="street-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'district_id')->dropDownList(ArrayHelper::map(District::find()->all(), 'id', 'name'))  ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Opslaan' : 'Opslaan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
