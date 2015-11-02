<?php

namespace app\controllers;

use Yii;
use app\models\Group;
use app\models\GroupSearch;
use app\models\District;
use app\models\Street;
use app\models\Grouptransaction;
use app\models\Streettransaction;

use app\models\StreettransactionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ActiveDataProvider;
use app\components\AccessRule;
use app\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
			'access' => [
				'class' => AccessControl::className(),
				// We will override the default rule config with the new AccessRule class
				'ruleConfig' => [
					'class' => AccessRule::className(),
				],
                'only' => ['index-opzetten', 'logout', 'delete-game', 'delete-all'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						// Allow users, moderators and admins to create
						'roles' => ['@'
						],
					],
					[
						'actions' => ['index-opzetten'],
						'allow' => true,
						// Allow users, moderators and admins to create
						'roles' => [
							User::ROLE_MODERATOR,
							User::ROLE_ADMIN
						],
					],
					[
						'actions' => ['delete-game', 'delete-all'],
						'allow' => true,
						// Allow admins to update
						'roles' => [
							User::ROLE_ADMIN
						],
					],
				],
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new StreettransactionSearch();

        $dataProviderStreet = $searchModel->searchPlayersDisplay(Yii::$app->request->queryParams);

        $query = Group::find();
        $dataProviderScore = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
			'dataProviderStreet' => $dataProviderStreet,
			'dataProviderScore' => $dataProviderScore,
        ]);
    }

	public function actionIndexOpzetten()
    {
		$dataProviderGroup = new ActiveDataProvider([
			'query' => Group::find(),
			'pagination' => false
		]);

		$dataProviderStreet = new ActiveDataProvider([
			'query' => Street::find(),
			'pagination' => false
		]);

		$dataProviderDistrict = new ActiveDataProvider([
			'query' => District::find(),
			'pagination' => false
		]);

        return $this->render('index-opzetten', [
            'dataProviderGroup' => $dataProviderGroup,
			'dataProviderStreet' => $dataProviderStreet,
			'dataProviderDistrict' => $dataProviderDistrict,
        ]);
    }

	/**
     * Deletes an existing Streettransactions and Grouptransactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteGame()
    {
		$modelsGrouptransactions = Grouptransaction::find()->all();
		foreach($modelsGrouptransactions as $modelGrouptransaction){	
			$modelGrouptransaction->delete();
		}
		$modelsStreettransactions = Streettransaction::find()->all();
		foreach($modelsStreettransactions as $modelStreettransaction){	
			$modelStreettransaction->delete();
		}

        return $this->redirect(['index-opzetten']);
    }

    /**
     * Deletes an existing Streettransactions and Grouptransactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteAll()
    {
		$modelsGrouptransactions = Grouptransaction::find()->all();
		foreach($modelsGrouptransactions as $modelGrouptransaction){	
			$modelGrouptransaction->delete();
		}
		$modelsStreettransactions = Streettransaction::find()->all();
		foreach($modelsStreettransactions as $modelStreettransaction){	
			$modelStreettransaction->delete();
		}

		$modelsGroups = Group::find()->all();
		foreach($modelsGroups as $modelsGroup){	
			$modelsGroup->delete();
		}

		$modelsStreets = Street::find()->all();
		foreach($modelsStreets as $modelStreet){	
			$modelStreet->delete();
		}

		$modelsDistricts = District::find()->all();
		foreach($modelsDistricts as $modelsDistrict){	
			$modelsDistrict->delete();
		}

        return $this->redirect(['index-opzetten']);
    }
   
	public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
