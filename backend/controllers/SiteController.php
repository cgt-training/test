<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use backend\models\AuthPermissionForm;
use backend\models\AssignPermissionForm;

use yii\db\Query;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','authpermission','assignpermission','permissions'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout="adminlogin";
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAuthpermission()
    {
        $model=new AuthPermissionForm();

        if ($model->load(Yii::$app->request->post()) && $model->createauth()) {
            return $this->redirect('@web/site/authpermission');
        }

        $arr_auth_type=["1"=>"Roles","2"=>"Permissions"];
        return $this->render('authpermission_form',[
            "arr_auth_type"=>$arr_auth_type,
            "model"=>$model,
            ]);
    }

    public function actionAssignpermission()
    {
        
        $model=new AssignPermissionForm();
        $post_data=Yii::$app->request->post();
        $post_data['AssignPermissionForm']['permission']=empty($post_data['permission']) ? [] : $post_data['permission']; 
        // unset($post_data['permission']);
        if ($model->load($post_data) && $model->assignPermission()) {
           
            return $this->redirect('@web/site/assignpermission');
        }
         $arr_roles=ArrayHelper::map(Yii::$app->authmanager->getRoles(),"name",'description');
         return $this->render('assignpermission_form',[
            "arr_roles"=>$arr_roles,
            "model"=>$model,
        ]);
    }

    public function actionPermissions()
    {

        $dataArray=array();

        $arr_permissions=ArrayHelper::map(Yii::$app->authmanager->getPermissions(),"name",'description');
        $dataArray["arr_permissions"]=$arr_permissions;

        $get_data=Yii::$app->request->get();
        if(!empty($get_data['id']))
        {

        $db = Yii::$app->db;
            $user_type=$get_data['id'];
            $sql="Select * from auth_item_child where parent=:user_type";

            $x=$db->createCommand($sql, [
                ':user_type' => $user_type,
            ])->queryAll();
            $dataArray['user_permissions']=ArrayHelper::getColumn($x,"child");
           
        }

        $permission_view=$this->renderPartial('_permission_view',$dataArray);
       
        echo $permission_view;
    }
}
