<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property string $name
 * @property string $members 
 * @property string $start_score 
 *
 * @property Grouptransaction[] $grouptransactions
 * @property Streettransaction[] $streettransactions
 */
class Group extends \yii\db\ActiveRecord
{
	public $score;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name', 'members', 'start_score'], 'required'],
			[['name', 'members'], 'string', 'max' => 255],
			[['start_score'], 'integer'],
            [['name'], 'unique'],
			[['score'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Groepsnaam',
			'members' => 'Leden', 
			'start_score' => 'Start Kapitaal', 
			'score' => 'Score', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrouptransactions()
    {
        return $this->hasMany(Grouptransaction::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreettransactions()
    {
        return $this->hasMany(Streettransaction::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupScore()
    {
		$this->score = 0;
        $models=$this->grouptransactions;
		foreach($models as $model){
			$this->score = $model->score + $this->score;
		}
		$this->score = $this->start_score + $this->score;
        return $this->score;
    }

	public static function getGroupsArray(){
		$cat = Group::find()->all();
		$cat = ArrayHelper::map($cat, 'id', 'name');
		return $cat;
	}

}
