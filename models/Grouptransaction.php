<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grouptransaction".
 *
 * @property integer $id
 * @property integer $street_transaction_id 
 * @property integer $group_id
 * @property integer $status
 * @property integer $score
 * @property string $datetime
 *
 * @property Streettransaction $streetTransaction 
 * @property Group $group
 */
class Grouptransaction extends \yii\db\ActiveRecord
{
	const STATUS_receive_lease=0;
	const STATUS_receive_lease_bonus=1;
    const STATUS_pay_lease=2;
    const STATUS_pay_lease_bonus=3;
    const STATUS_penalty_claim_own_street=4;
    const STATUS_penalty_claim_old_street=5;
    const STATUS_window_cleaned=6;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grouptransaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['street_transaction_id', 'group_id', 'status', 'score', 'datetime'], 'required'],
			[['street_transaction_id', 'group_id', 'status', 'score'], 'integer'],
			[['datetime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
			'status' => 'Status',
            'score' => 'Mutatie (€)',
            'datetime' => 'Datum',
        ];
    }

	/** 
	 * @return \yii\db\ActiveQuery 
	 */ 
	public function getStreetTransaction() 
	{ 
		return $this->hasOne(Streettransaction::className(), ['id' => 'street_transaction_id']); 
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

	/**
	* Retrieves een lijst met mogelijke rollen die een deelnemer tijdens een hike kan hebben
	* @return array an array of available rollen.
	*/
	public static function getStatusOptions()
	{
		return array(
			self::STATUS_receive_lease=>'Ontvangen Pacht',
			self::STATUS_receive_lease_bonus=>'Ontvangen Pacht En Wijk Bonus',
			self::STATUS_pay_lease=>'Betaalde Pacht',
			self::STATUS_pay_lease_bonus=>'Betaalde Pacht En Wijk Bonus',
			self::STATUS_penalty_claim_own_street=>'Boete: Eigen Straat',
			self::STATUS_penalty_claim_old_street=>'Boete: Twee Oude Straten Achter Elkaar ',
			self::STATUS_window_cleaned=>'Ramen Gewassen',
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
}
