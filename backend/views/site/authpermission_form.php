<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = 'Create Auth ';
?>
<div class="auth-create">

    <h1><?= Html::encode($this->title) ?></h1>

  <div class="auth-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'auth_type')->dropDownList($arr_auth_type); ?>

    <?= $form->field($model, 'auth_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_description')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create',['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
