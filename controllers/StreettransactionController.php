<?php

namespace app\controllers;

use Yii;
use app\models\Grouptransaction;
use app\models\District;
use app\models\Street;
use app\models\Streettransaction;
use app\models\StreettransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\components\AccessRule;
use app\models\User;
use yii\helpers\VarDumper;
use yii\helpers\Json;

/**
 * StreettransactionController implements the CRUD actions for Streettransaction model.
 */
class StreettransactionController extends Controller
{
	private $_claim_time = 15;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
			'access' => [
				'class' => AccessControl::className(),
				// We will override the default rule config with the new AccessRule class
				'ruleConfig' => [
					'class' => AccessRule::className(),
				],
                'only' => ['index', 'view', 'create', 'update', 'delete', 'update-all', 'street-list'],
				'rules' => [
					[
						'actions' => ['index', 'view', 'street-list'],
						'allow' => true,
						// Allow users, moderators and admins to create
						'roles' => [
							User::ROLE_USER,
							User::ROLE_MODERATOR,
							User::ROLE_ADMIN
						],
					],
					[
						'actions' => ['create', 'update', 'delete', 'update-all'],
						'allow' => true,
						// Allow moderators and admins to update
						'roles' => [
							User::ROLE_MODERATOR,
							User::ROLE_ADMIN
						],
					],
				],
			],
        ];
    }



    /**
     * Lists all Streettransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StreettransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Streettransaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Streettransaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Streettransaction();

        if ($model->load(Yii::$app->request->post())){
			$etime = strtotime("$model->start_date $model->start_time");
			$model->start_datetime = date('Y-m-d H:i:s', $etime);
			$model->id = Streettransaction::getNewID();

			// This function set the status
			$model->status = $model->determineStatus($model->id,
													 $model->street_id,
													 $model->group_id,
													 $model->start_datetime);

			switch($model->status){
				case Streettransaction::STATUS_new:
				case Streettransaction::STATUS_old_valid:
					$etime = strtotime("$model->start_date $model->start_time");
					$etime = strtotime("+$this->_claim_time minutes", $etime);
					$model->end_datetime = date('Y-m-d H:i:s', $etime);	
					break;
				case Streettransaction::STATUS_own_street:
				case Streettransaction::STATUS_consecutive_old_streets:
				case Streettransaction::STATUS_already_claimed_street:
					$model->end_datetime = 0;
					break;
				default:
					break;
			}

			if($model->save() &&
			   $this->updateRelatedGroupTransactions($model, 'create') &&
			   $this->updateAllStreetTransactions($model->start_datetime,
												  'create')){
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}
		$model->start_date = date('Y-m-d');
		return $this->render('create', [
				'model' => $model,
			]);    
	}

    /**
     * Updates an existing Streettransaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$etime = strtotime($model->start_datetime);
		$model->start_date = date('Y-m-d', $etime);
		$model->start_time = date('H:i:s', $etime);
        if ($model->load(Yii::$app->request->post())) {
			$etime = strtotime("$model->start_date $model->start_time");
			$model->start_datetime = date('Y-m-d H:i:s', $etime);
			$model->status = $model->determineStatus($model->id,
													 $model->street_id,
													 $model->group_id,
													 $model->start_datetime);

			switch($model->status){
				case Streettransaction::STATUS_new:
				case Streettransaction::STATUS_old_valid:
					$etime = strtotime("$model->start_date $model->start_time");
					$etime = strtotime("+$this->_claim_time minutes", $etime);
					$model->end_datetime = date('Y-m-d H:i:s', $etime);
					break;
				case Streettransaction::STATUS_own_street:
				case Streettransaction::STATUS_consecutive_old_streets:
				case Streettransaction::STATUS_already_claimed_street:
					$model->end_datetime = 0;
					break;
				default:
					break;
			}
	        if($model->save() &&
			   $this->updateRelatedGroupTransactions($model, 'update') &&
			   $this->updateAllStreetTransactions($model->start_datetime,
												  'update')){
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}
		return $this->render('update', [
			'model' => $model,
		]);
    }

    /**
     * Deletes an existing Streettransaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$modelsGrouptransactions = Grouptransaction::find()
			->where('street_transaction_id = :street_transaction_id',
					[':street_transaction_id' => $id])
			->all();
		foreach($modelsGrouptransactions as $modelGrouptransaction){	
			$modelGrouptransaction->delete();
		}
		$start_datetime = $this->findModel($id)->start_datetime;
        $this->findModel($id)->delete();
		$this->updateAllStreetTransactions($start_datetime, 'delete');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Streettransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Streettransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Streettransaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionUpdateAll(){
		$this->updateAllStreetTransactions(0, 0, 'update');
		return $this->redirect(['index']);
	}

	/**
	 * Updates all streettransaction and related grouptransaction.
	 * If input date is given, only transactions after this date
	 * are updated.
	 * If no date is given, all transactions are updated.
	 * @param datetime $start_time
	 * @return true if update is completed
	 */
	public function updateAllStreetTransactions($start_datetime, $action){
		// on a update All transactions must be redetermine.
		// If start date is changed, also the previous actions might be changed.
		if ($action == 'update') {
			$streettransactions = Streettransaction::find()
				->where('start_datetime > :start_datetime',
						[':start_datetime' => $start_datetime])
				->orderBy(['start_datetime'=>SORT_ASC])
				->all();;			
		}
		if ($action == 'delete' || $action == 'create') {
			$streettransactions = Streettransaction::find()
				->where('start_datetime > :start_datetime',
						[':start_datetime' => $start_datetime])
				->orderBy(['start_datetime'=>SORT_ASC])
				->all();
		}
		foreach($streettransactions as $streettransaction){
			$etime = strtotime($streettransaction->start_datetime);
			$streettransaction->status = $streettransaction->determineStatus($streettransaction->id,
																			 $streettransaction->street_id,
																			 $streettransaction->group_id,
																			 $streettransaction->start_datetime);

			switch($streettransaction->status){
				case Streettransaction::STATUS_new:
				case Streettransaction::STATUS_old_valid:
					$etime = strtotime("+$this->_claim_time minutes", $etime);
					$streettransaction->end_datetime = date('Y-m-d H:i:s', $etime);
					break;
				case Streettransaction::STATUS_own_street:
				case Streettransaction::STATUS_consecutive_old_streets:
				case Streettransaction::STATUS_already_claimed_street:
					$streettransaction->end_datetime = 0;
					break;
				default:
					break;
			}

			if($streettransaction->save() &&
			   $this->updateRelatedGroupTransactions($streettransaction, 'update')){
				continue;
			}
			return $this->render('/site/error', [
				'model' => $streettransaction]);
		}

        $searchModel = new StreettransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	//	return true;
	}

	/**
	 * Updates related related grouptransaction.
	 * If no date is given, all transactions are updated.
	 * @param datetime $start_time &  $action
	 * If action != create, then the records are deleted first. 
	 * @return true if update is completed
	 */
	public function updateRelatedGroupTransactions($streettransaction, $action){
		/* The easy (slow) way. Delete all grouptransaction with a specific
		 * stransaction ID. And create new grouptransaction in the sameway
		 * in the create action.
		 */
		if($action == 'update'){
			$grouptransactionsOld = Grouptransaction::find()
				->where('street_transaction_id = :street_transaction_id',
						[':street_transaction_id' => $streettransaction->id])
				->all();
			foreach($grouptransactionsOld as $grouptransactionOld){	
				$grouptransactionOld->delete();
			}
		}

		switch($streettransaction->status){
			case Streettransaction::STATUS_new:
			case Streettransaction::STATUS_old_valid:
				# Group gets score for cleaning.
				$grouptransactionNew = new Grouptransaction();
				$grouptransactionNew->group_id = $streettransaction->group_id;
				$grouptransactionNew->score = $streettransaction->street->score;
				$grouptransactionNew->datetime = $streettransaction->start_datetime;
				$grouptransactionNew->status = Grouptransaction::STATUS_window_cleaned;
				$grouptransactionNew->street_transaction_id = $streettransaction->id;
				break;
			break;
			case Streettransaction::STATUS_own_street:
				$grouptransactionNew = new Grouptransaction();
				# group claims street but still owns it.
				$grouptransactionNew->group_id = $streettransaction->group_id;
				$grouptransactionNew->score = -$streettransaction->street->score;
				$grouptransactionNew->datetime = $streettransaction->start_datetime;
				$grouptransactionNew->status = Grouptransaction::STATUS_penalty_claim_own_street;
				$grouptransactionNew->street_transaction_id = $streettransaction->id;
				break;
			case Streettransaction::STATUS_consecutive_old_streets:
				$grouptransactionNew = new Grouptransaction();
				# group claims two consecutive old streets.
				$grouptransactionNew->group_id = $streettransaction->group_id;
				$grouptransactionNew->score = -$streettransaction->street->score;
				$grouptransactionNew->datetime = $streettransaction->start_datetime;
				$grouptransactionNew->status = Grouptransaction::STATUS_penalty_claim_old_street;
				$grouptransactionNew->street_transaction_id = $streettransaction->id;
				break;
			case Streettransaction::STATUS_already_claimed_street:
				# When the street Claim is not valid, the group who claimed it
				# will get negative points and the owner of the streets get
				# point.
				$grouptransactionNewOwner = new Grouptransaction();
				$grouptransactionNewClaim = new Grouptransaction();

				$grouptransactionNewOwner->group_id = $streettransaction->ownerOfClaimedStreet(
					$streettransaction->id,
					$streettransaction->street_id,
					$streettransaction->start_datetime);

				$districtID = Street::getDistrictID($streettransaction->street_id);
				$StreetScore = Street::getStreetScore($streettransaction->street_id);

				if($streettransaction->groupOwnsAllStreetsInDistrict()){
					$districtScore = District::getDistrictScore($districtID);
					$grouptransactionNewOwner->score = $StreetScore + $districtScore;
					$grouptransactionNewOwner->status = Grouptransaction::STATUS_receive_lease_bonus;
	
					$grouptransactionNewClaim->score = -$StreetScore - $districtScore;
					$grouptransactionNewClaim->status = Grouptransaction::STATUS_pay_lease_bonus;
				} else {
					$grouptransactionNewOwner->score = $StreetScore;
					$grouptransactionNewOwner->status = Grouptransaction::STATUS_receive_lease;
	
					$grouptransactionNewClaim->score = -$StreetScore;
					$grouptransactionNewClaim->status = Grouptransaction::STATUS_pay_lease;
				}
				$grouptransactionNewClaim->street_transaction_id = $streettransaction->id;
				$grouptransactionNewClaim->group_id = $streettransaction->group_id;
				$grouptransactionNewClaim->datetime = $streettransaction->start_datetime;
				$grouptransactionNewOwner->street_transaction_id = $streettransaction->id;
				$grouptransactionNewOwner->datetime = $streettransaction->start_datetime;
				break;
			default:
				break;
		}
		
		if(($streettransaction->status == Streettransaction::STATUS_new or		
			$streettransaction->status == Streettransaction::STATUS_old_valid or
			$streettransaction->status == Streettransaction::STATUS_consecutive_old_streets or		
			$streettransaction->status == Streettransaction::STATUS_own_street) and
			$grouptransactionNew->save()){
				return true;
		}
		if($streettransaction->status == Streettransaction::STATUS_already_claimed_street &&
		   $grouptransactionNewClaim->save() &&
		   $grouptransactionNewOwner->save()) {
				return true;
		}
		return false;
	}

	public function actionStreetList($search = null, $id = null) {
		$out = ['more' => false];

		if (!is_null($search)) {
			$query = (new \yii\db\Query());
			$query->select('id, name AS text')
				->from('street')
				->where('name LIKE "%' . $search .'%"')
				->limit(20);
			$command = $query->createCommand();
			$data = $command->queryAll();
			$out['results'] = array_values($data);
		}
		elseif ($id > 0) {
			//$out['results'] = ['id' => 0, 'text' => 'WEL matching records found'];
			$out['results'] = ['id' => $id, 'text' => Street::find($id)->name];
		}
		else {
			$out['results'] = ['id' => 0, 'text' => 'No matching records found'];
		}
		echo Json::encode($out);
	}
}