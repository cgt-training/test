<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use backend\models\Company;
use backend\models\Branch;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_fk_id')->dropDownList(
                                            ArrayHelper::map(company::find()->asArray()->all(),'company_id','company_name'),
                                            [
                                                'prompt'=>"Select Company",
                                                'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('department/company?id=').'"+$(this).val(), function( data ) {
                                                  $( "select#department-branch_fk_id" ).html( data );
                                                });'  
                                            ]
                                        )->label("Select Company")
                                    ?>
    
    <?= $form->field($model, 'branch_fk_id')->dropDownList(empty($model->company_fk_id) ? [] : ArrayHelper::map(Branch::find()->where(['company_fk_id'=>$model->company_fk_id])->asArray()->all(),'branch_id','branch_name'),['prompt'=>"Select Branch"])->label("Select Branch"); ?>

    <?= $form->field($model, 'department_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_create')->textInput() ?>

    <?= $form->field($model, 'department_status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
