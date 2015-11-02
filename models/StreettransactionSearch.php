<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Streettransaction;

/**
 * StreettransactionSearch represents the model behind the search form about `app\models\Streettransaction`.
 */
class StreettransactionSearch extends Streettransaction
{
	public $street;
	public $district;
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'street_id', 'group_id', 'status'], 'integer'],
           [['start_datetime', 'end_datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Streettransaction::find();
		$query->joinWith(['street', 'district']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['start_datetime'=>SORT_DESC]]
        ]);
 
		$dataProvider->sort->attributes['street'] = [
			'asc' => ['street.name' => SORT_ASC],
			'desc' => ['street.name' => SORT_DESC],
		];

		$dataProvider->sort->attributes['district'] = [
			'asc' => ['district.name' => SORT_ASC],
			'desc' => ['district.name' => SORT_DESC],
		];


		$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'street_id' => $this->street_id,
            'group_id' => $this->group_id,
			'status' => $this->status,
			'start_datetime' => $this->start_datetime,
			'end_datetime' => $this->end_datetime,
        ])
			->andFilterWhere(['like', 'street.name', $this->street])
			->andFilterWhere(['like', 'district.name', $this->district]);;
        return $dataProvider;
    }

	public function searchPlayersDisplay($params)
    {
		$claim_time = 1;
		date_default_timezone_set("Europe/Amsterdam");
		$current_datetime = date('Y-m-d H:i:s');
		$etime = strtotime($current_datetime);
		$etime = strtotime("+$claim_time minutes", $etime);
		$expire_datetime = date('Y-m-d H:i:s', $etime);

        $query = Streettransaction::find();
		$query->joinWith(['street', 'district'])
			->where('end_datetime > :current_datetime and
					end_datetime < :expire_datetime',
					[':current_datetime' => $current_datetime,
					 ':expire_datetime' => $expire_datetime])
			->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
 
		$dataProvider->sort->attributes['street'] = [
			'asc' => ['street.name' => SORT_ASC],
			'desc' => ['street.name' => SORT_DESC],
		];

		$dataProvider->sort->attributes['district'] = [
			'asc' => ['district.name' => SORT_ASC],
			'desc' => ['district.name' => SORT_DESC],
		];

		$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'street_id' => $this->street_id,
            'group_id' => $this->group_id,
			'status' => $this->status,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
        ])
			->andFilterWhere(['like', 'street.name', $this->street])
			->andFilterWhere(['like', 'district.name', $this->district]);;
        return $dataProvider;
    }
}
