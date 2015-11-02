<?php

namespace app\controllers;

use Yii;
use app\models\Grouptransaction;
use app\models\GrouptransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use app\models\Group;

use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

/**
 * GrouptransactionController implements the CRUD actions for Grouptransaction model.
 */
class GrouptransactionController extends Controller
{
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
                'only' => ['index', 'view', 'create', 'update', 'delete'],
				'rules' => [
					[
						'actions' => ['index', 'view'],
						'allow' => true,
						// Allow users, moderators and admins to create
						'roles' => [
							User::ROLE_USER,
							User::ROLE_MODERATOR,
							User::ROLE_ADMIN
						],
					],
					[
						'actions' => ['create', 'update', 'delete'],
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
     * Lists all Grouptransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
		$grapharr = array();
        $searchModel = new GrouptransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$groupcount = 0;
		$groups = Group::find()
			->orderBy(['name'=>SORT_ASC, ])
			->all();
		foreach($groups as $group)
		{
			$grouptransactions = Grouptransaction::find()
				->where('group_id = :group_id',
						[':group_id' => $group->id])
				->orderBy(['datetime'=>SORT_ASC])
				->all();
			$counter = 0;
			$scoreArray = array();
			foreach($grouptransactions as $grouptransaction)
			{
				if ($counter == 0){
					$previousTotalscore = $group->start_score;
				} else {
					$previousCounter = $counter - 1;
					$previousTotalscore = $scoreArray[$previousCounter][1];
				}				
				$scoreArray[$counter][0] = strtotime($grouptransaction->datetime)*1000;
				$scoreArray[$counter][1] = $grouptransaction->score + $previousTotalscore;
				$counter++;
			}
			$grapharr[$groupcount]['name'] = $group->name;
			$grapharr[$groupcount]['data'] = $scoreArray;
			$groupcount++;
		}

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'graphData' => $grapharr,	
        ]);
    }

    /**
     * Displays a single Grouptransaction model.
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
     * Creates a new Grouptransaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grouptransaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Grouptransaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Grouptransaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Grouptransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grouptransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grouptransaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
