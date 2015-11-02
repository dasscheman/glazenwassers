<?php

namespace app\models;

use Yii;
use app\models\Street;
use app\models\District;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "streettransaction".
 *
 * @property integer $id
 * @property integer $street_id
 * @property integer $group_id
 * @property integer $status
 * @property string $start_datetime
 * @property string $start_date
 * @property string $start_time
 * @property string $end_datetime
 *
 * @property Grouptransaction[] $grouptransactions 
 * @property Street $street
 * @property Group $group
 */
class Streettransaction extends \yii\db\ActiveRecord
{
	public $start_date;
	public $start_time;

	const STATUS_new=0;
	const STATUS_old_valid=1;
    const STATUS_own_street=2;
    const STATUS_consecutive_old_streets=3;
    const STATUS_already_claimed_street=4;
  
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'streettransaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['street_id', 'group_id', 'status', 'start_datetime', 'end_datetime'], 'required'],
			[['street_id', 'group_id', 'status'], 'integer'],
			[['start_datetime', 'start_date','start_time', 'end_datetime'], 'safe'],
			['start_datetime', 'unique', 'targetAttribute' => ['street_id','start_datetime'],
			 'message' => 'Staat ... kan niet twee keer op exact dezelfde tijd (...) geclaimt worden.'
           ],
			['start_datetime', 'unique', 'targetAttribute' => ['group_id','start_datetime'],
			 'message' => 'Group ... kan niet twee claims op exact dezelfde tijd (...) hebben..'
           ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'street_id' => 'Straatnaam',
            'group_id' => 'Groepsnaam',
			'status' => 'Status',
	        'start_datetime' => 'Start Datum',
			'end_datetime' => 'End Date', 
            'street' => 'Straatnaam',
            'district' => 'Wijk',

        ];
    }

	/** 
    * @return \yii\db\ActiveQuery 
    */ 
	public function getGrouptransactions() 
	{ 
		return $this->hasMany(Grouptransaction::className(), ['street_transaction_id' => 'id']); 
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreet()
    {
        return $this->hasOne(Street::className(), ['id' => 'street_id']);
    }

    public function getStreetName()
    {    
        $model=$this->street;
        return $model?$model->name:'';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    public function getGroupName()
    {    
        $model=$this->group;
        return $model?$model->name:'';
    }

    public function getDistrict() 
	{
		return $this->hasOne(District::className(), ['id' => 'district_id'])
			->via('street');
	}

	/**
	* Retrieves een lijst met mogelijke rollen die een deelnemer tijdens een hike kan hebben
	* @return array an array of available rollen.
	*/
	public static function getStatusOptions()
	{
		return array(
			self::STATUS_new=>'Nieuwe Claim',
			self::STATUS_old_valid=>'Geldige Oude Claim',
			self::STATUS_own_street=>'Claim Op Eigen Straat',
			self::STATUS_consecutive_old_streets=>'Twee Oude Claims Achter Elkaar',
			self::STATUS_already_claimed_street=>'Claimed Door Andere Groep',
		    );
	}

	/**
	* @return string de rol text display
	*/
	public function getStatusText()
	{
		$statusOptions=$this->getStatusOptions();   
		return isset($statusOptions[$this->status]) ?
		    $statusOptions[$this->status] : "Onbekende status";
	}

	public function determineStatus($id, $street_id, $group_id, $start_datetime)
	{
		$streetOwnerId = Streettransaction::ownerOfClaimedStreet($id, $street_id, $start_datetime);
		if(!empty($streetOwnerId)){			
			if($group_id == $streetOwnerId){
				return Streettransaction::STATUS_own_street;
			}
			return Streettransaction::STATUS_already_claimed_street;
		}

		if(Streettransaction::isStreetClaimedBeforeByGroup($id, $street_id, $group_id, $start_datetime)){
			if(Streettransaction::isClaimConsecutiveOldStreets($id, $group_id, $start_datetime)){
				return Streettransaction::STATUS_consecutive_old_streets;
			}
			return Streettransaction::STATUS_old_valid;
		}
		return Streettransaction::STATUS_new;
	}

	public function ownerOfClaimedStreet($id, $street_id, $start_datetime){
		$streettransaction = Streettransaction::find()
			->where('id != :transaction_id and
					 street_id = :street_id and
					 start_datetime < :start_datetime and
					 end_datetime > :end_datetime',
					[':transaction_id' => $this->id,
					 ':street_id' => $this->street_id,
					 ':start_datetime' => $this->start_datetime,
					 ':end_datetime' => $this->start_datetime])

			->one();

		if(isset($streettransaction->id)){
			return $streettransaction->group_id;
		}
		return false;
	}

	public function isStreetClaimedBeforeByGroup($id, $street_id, $group_id, $start_datetime){
		$streettransaction = Streettransaction::find()
			->where('id != :transaction_id and
					 street_id = :street_id and
					 group_id = :group_id and
					 start_datetime < :start_datetime and
					 status = :status_new',
					[':transaction_id' => $id,
				     ':street_id' => $street_id,
					 ':group_id' => $group_id,
					 ':start_datetime' => $start_datetime,
					 ':status_new' => Streettransaction::STATUS_new])
			->one();
		if(isset($streettransaction->id)){
			return true;
		}

		return false;
	}
	
	public function isClaimConsecutiveOldStreets($id, $group_id, $start_datetime){
		$streettransaction = Streettransaction::find()
			->where('id != :transaction_id and
					 group_id = :group_id and
					 start_datetime < :start_datetime and
					 (status = :status_new or 
					 status = :status_old)',					
					[':transaction_id' => $id,
					 ':group_id' => $group_id,
					 ':start_datetime' => $start_datetime,
					 ':status_new' => Streettransaction::STATUS_new,
					 ':status_old' => Streettransaction::STATUS_old_valid])
			/*->where('id != :transaction_id and
					 group_id = :group_id and
					 start_datetime < :start_datetime and
					 status = :status_new or
					 status = :status_old',
					[':transaction_id' => $id,
					 ':group_id' => $group_id,
					 ':start_datetime' => $start_datetime,
					 ':status_new' => Streettransaction::STATUS_new,
					 ':status_old' => Streettransaction::STATUS_old_valid])*/
			->orderBy(['start_datetime'=>SORT_DESC])
			->one();

		if(!empty($streettransaction) &&
		   $streettransaction->status == Streettransaction::STATUS_old_valid){
			return true;
		}
		return false;
	}

	public function groupOwnsAllStreetsInDistrict(){
		$streetsInDistrict = Street::getStreetsInDistrict($this->district->id);

		$districtStreetsOwnedByGroup = $this->getStreetsInDistrictOwnedByGroup();
		if(is_array($districtStreetsOwnedByGroup)){		
			$result=array_diff($streetsInDistrict,$districtStreetsOwnedByGroup);
		}

		if ( $streetsInDistrict == $districtStreetsOwnedByGroup ) {
			return true;
		}

		return false;
	}	

	public function getStreetsInDistrictOwnedByGroup(){			
		$results = Streettransaction::find()
			->where('group_id = :group_id and
					 start_datetime < :start_datetime and
					 end_datetime > :end_datetime',
					[':group_id' => $this->group_id,
					 ':start_datetime' => $this->start_datetime,
					 ':end_datetime' => $this->start_datetime,])
			->all();

		foreach($results as $result){
			if(Street::getDistrictID($result->street_id) == $this->district->id){
				$stack[$result->street_id] = $this->district->id;
			}
		}
		if(isset($stack))
			return $stack;
	}

	public static function getNewID(){
		$streettransaction = Streettransaction::find()
			->orderBy(['id'=>SORT_DESC, ])
			->one();
		if(isset($streettransaction->id)){
			return $streettransaction->id + 1;
		}
		return 1;
	}
}