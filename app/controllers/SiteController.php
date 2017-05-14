<?php
namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\LoginForm;
use app\modules\blog\models\Post;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['accept-notification'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['accept-notification'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'accept-notification' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->redirect(['blog/posts/index']);
        return $this->render('index');
    }

    public function actionAcceptNotification()
    {
        if ($lastPostId = Post::find()->orderBy('id DESC')->select('id')->limit(1)->scalar()) {
            Yii::$app->user->identity->setLastNewsViewed($lastPostId);
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(s('app.admin_email'))) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }
}
    