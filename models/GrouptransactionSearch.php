<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grouptransaction;

/**
 * GrouptransactionSearch represents the model behind the search form about `app\models\Grouptransaction`.
 */
class GrouptransactionSearch extends Grouptransaction
{
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'street_transaction_id', 'group_id', 'status', 'score'], 'integer'],
           [['datetime'], 'safe'],
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
        $query = Grouptransaction::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['datetime'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
			'street_transaction_id' => $this->street_transaction_id, 
            'group_id' => $this->group_id,
			'status' => $this->status, 
            'score' => $this->score,
	        'datetime' => $this->datetime,
        ]);

        return $dataProvider;
    }
}
