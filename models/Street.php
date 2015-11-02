<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Group;
use app\models\Street;
use app\models\Streettransaction;

/**
 * This is the model class for table "street".
 *
 * @property integer $id
 * @property string $name
 * @property integer $district_id
 * @property integer $score
 *
 * @property District $district
 * @property Streettransaction[] $streettransactions
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'street';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'district_id', 'score'], 'required'],
            [['district_id', 'score'], 'integer'],
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
            'name' => 'Straatnaam',
            'district_id' => 'Wijk',
            'score' => 'Prijs (€)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    public function getDistrictName()
    {    
        $model=$this->district;
        return $model?$model->name:'';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreettransactions()
    {
        return $this->hasMany(Streettransaction::className(), ['street_id' => 'id']);
    }

	public static function getStreetsArray(){
		$cat = Street::find()
			->orderBy(['name'=>SORT_ASC, ])
			->all();
		$cat = ArrayHelper::map($cat, 'id', 'name');
		return $cat;
	}

	public static function getStreetsArrayNoKey(){
		$cat = array();
		$cat = Street::find()
			->orderBy(['id'=>SORT_ASC, ])
			->all();
		$cat = ArrayHelper::getColumn($cat, 'name');
		return $cat;
	}

    public static function getDistrictID($street_id){
		$street = Street::find()
			->where('id = :street_id',
					[':street_id' => $street_id])
			->one();
		if(isset($street->id)){
			return $street->district_id;
		}
		return ;
	}

    public static function getStreetScore($street_id){
		$street = Street::find()
			->where('id = :street_id',
					[':street_id' => $street_id])
			->one();
		if(isset($street->id)){
			return $street->score;
		}
		return ;
	}

    public static function getStreetsInDistrict($district){
		$street = Street::find()
			->where('district_id = :district',
					[':district' => $district])
			->all();
		return ArrayHelper::map($street, 'id', 'district_id');
	}

	public function getDataArrayForGraph(){
		$grapharr = array();
		$groupcount = 0;
		$groups = Group::find()
			->orderBy(['name'=>SORT_ASC, ])
			->all();
		foreach($groups as $group)
		{
			$streetcount = 0;
			$grapharr[$groupcount]['name'] = $group->name;
		
			$streets = Street::find()
				->orderBy(['id'=>SORT_ASC, ])
				->all();

			$transactioncount = 0;
			foreach($streets as $street)
			{	
				$streettransactions = Streettransaction::find()
					->where('street_id =:street_id and
							group_id =:group_id and
							(status =:statusNew or
							status =:statusOld)',
						[':street_id' => $street->id,
						 ':group_id' => $group->id,
						 ':statusNew' => Streettransaction::STATUS_new,
						 ':statusOld' => Streettransaction::STATUS_old_valid])
					->orderBy(['start_datetime'=>SORT_ASC, ])
					->all();
				foreach($streettransactions as $streettransaction)
				{
					$grapharr[$groupcount]['data'][$transactioncount]['x'] = $streetcount;
					$grapharr[$groupcount]['data'][$transactioncount]['low'] = strtotime($streettransaction->start_datetime)*1000;
					$grapharr[$groupcount]['data'][$transactioncount]['high'] = strtotime($streettransaction->end_datetime)*1000;
					$transactioncount++;
				}
				$streetcount++;
			}
			$groupcount++;
		}
		/*if($grapharr == NULL);{
			return array();
		}*/
		return $grapharr;
	}

}