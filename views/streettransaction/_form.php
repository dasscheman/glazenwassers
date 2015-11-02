<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Group;
use app\models\Street;
use kartik\date\DatePicker; 
use kartik\time\TimePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Streettransaction */
/* @var $form yii\widgets\ActiveForm */

// The controller action that will render the list
$url = \yii\helpers\Url::to(['street-list']);
 
// Script to initialize the selection based on the value of the select2 element
$initScript = <<< SCRIPT
function (element, callback) {
    var id=\$(element).val();
    if (id !== "") {
        \$.ajax("{$url}?id=" + id, {
            dataType: "json"
        }).done(function(data) { callback(data.results);});
    }
}
SCRIPT;
?>

<div class="streettransaction-form">

    <?php $form = ActiveForm::begin(); ?>
    <?//= $form->field($model, 'start_time')->textInput() ?>
	<?= $form->errorSummary($model); ?>

    <?//= $form->field($model, 'street_id')->dropDownList(ArrayHelper::map(Street::find()->all(), 'id', 'name'))  ?>

	<?php echo $form->field($model, 'street_id')->widget(Select2::classname(), [
		'options' => ['placeholder' => 'Zoek voor een straat ...'],
		'pluginOptions' => [
			'allowClear' => true,
			'minimumInputLength' => 1,
			'ajax' => [
				'url' => $url,
				'dataType' => 'json',
				'data' => new JsExpression('function(term,page) { return {search:term}; }'),
				'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
			],
			'initSelection' => new JsExpression($initScript)
		],
	]); ?>

	<?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->all(), 'id', 'name'))  ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(),[
			'name' => 'start_date',
			'value'=> $model->start_date,
			//'type' => DatePicker::TYPE_INLINE,
			'convertFormat' => true,
			'pluginOptions' => [
			   'format' => 'yyyy-MM-dd',
				'todayHighlight' => true
		   ]
	   ]); ?>

    <?= $form->field($model, 'start_time')->widget(TimePicker::classname(), [
			'name' => 'start_time',
			'value'=> $model->start_time,
			'pluginOptions' => [
				'showSeconds' => true,
				'showMeridian' => false,
				'minuteStep' => 1,
				'secondStep' => 5,
			]
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Opslaan' : 'Opslaan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
