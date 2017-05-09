<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\ProfileForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
       
        $dataArray=array(
            "status" => "success",
            "statusMessage"=> "Hello Akash"
            );
        return $this->render('index',$dataArray);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
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

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $user_data=Yii::$app->request->post();
        if (!empty($user_data)) {

           if($model->load($user_data)){

           
            $model->userimage = UploadedFile::getInstance($model, 'userimage');

            $filename=$model->username.".".$model->userimage->extension;
            $model->userimage->saveAs("img/uploads/".$filename);
            $model->userimage=$filename;
            if ($user = $model->signup()) {
                if(!empty($user_data['user_type'])){
                    
                    $auth = \Yii::$app->authManager;
                    $authorRole = $auth->getRole($user_data['user_type']);
                    $auth->assign($authorRole, $user->getId());
                }

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

            

        }

        $user_types=[
            "admin"=>"Admin",
            "manager"=>"Manager",
            "employee"=>"Employee"
            ];

        return $this->render('signup', [
            'model' => $model,
            'user_types'=>$user_types
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $user_id = Yii::$app->user->getId();
        $model = User::find($user_id)->where(['id' => $user_id])->one();
        $user_data=Yii::$app->request->post();

        if (!empty($user_data)) {            
           $profilemodel=new ProfileForm();
           $profilemodel->scenario="update";
           $user_data['ProfileForm']=$user_data['User'];
           $user_data['ProfileForm']['id']=$user_id;
           if($profilemodel->load($user_data)){
                 
                $model->userimage = UploadedFile::getInstance($model, 'userimage');
                if(!empty($model->userimage))
                {
                    $filename=$profilemodel->username.".".$profilemodel->userimage->extension;
                    $profilemodel->userimage->saveAs("img/uploads/".$filename);
                    $profilemodel->userimage=$filename;
                }
                if($userprofile = $profilemodel->updateProfile())
                {
                    return $this->redirect('@web/site/profile');
                }
            
            }            

        }
        

        $user_types=[
            "admin"=>"Admin",
            "manager"=>"Manager",
            "employee"=>"Employee"
            ];

        return $this->render('profile', [
            'model' => $model,
            'user_types'=>$user_types
        ]);
    }
}
