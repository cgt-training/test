<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'userimage')->fileInput() ?>

    <?= $form->field($model,'role')->dropDownList($arr_roles=ArrayHelper::map(Yii::$app->authmanager->getRoles(),"name",'description')); ?>

    <div class="form-group">
        <?= Html::submitButton(empty($model->id) ? 'Create' : 'Update', ['class' => empty($model->id) ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
