<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property integer $score
 *
 * @property Street[] $streets
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'score'], 'required'],
            [['score'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Wijknaam',
            'score' => 'Bijbetaling voor een hele wijk (€)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreets()
    {
        return $this->hasMany(Street::className(), ['district_id' => 'id']);
    }

	public static function getDistrictsArray(){
		$cat = District::find()->all();
		$cat = ArrayHelper::map($cat, 'id', 'name');
		return $cat;
	}

/*
    public static function getDistrictScore($district){
		$district = District::find()
			->where('id = :district',
					[':district' => $district])
			->one();
		return $district->score;
	}*/

 /*   public static function getDistrictName($district){
		$district = District::find()
			->where('id = :district',
					[':district' => $district])
			->one();
		return $district->name;
	}*/
}
