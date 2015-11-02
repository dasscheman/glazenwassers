<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Group;

/* @var $this yii\web\View */
/* @var $model app\models\Grouptransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grouptransaction-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->errorSummary($model); ?>

    <?//= $form->field($model, 'group_id')->textInput() ?>
	<?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->all(), 'id', 'name'))  ?>

	<?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Opslaan' : 'Opslaan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
