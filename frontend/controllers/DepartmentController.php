<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use frontend\models\Department;
use frontend\models\DepartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Branch;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['view','create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Department model.
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
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('departmentadd')) {
            $model = new Department();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->department_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        else
        {
            return $this->redirect('@web/department/index');
        }
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       if (Yii::$app->user->can('departmentedit')) { 
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->department_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
        else
        {
            return $this->redirect('@web/department/index');
        }
    }

    /**
     * Deletes an existing Department model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('departmentdelete')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        else
        {
            return $this->redirect('@web/department/index');
        }
    }

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCompany($id)
    {


        $branches = Branch::find()
                ->where(['company_fk_id' => $id])
                ->orderBy('branch_id DESC')
                ->all();
        echo "<option>Select Branch....</option>";
        if(count($branches)){
            foreach($branches as $branch){
                echo "<option value='".$branch->branch_id."'>".$branch->branch_name."</option>";
            }
        }
    }
}
