<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\BranchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'company_fk_id') ?>

    <?= $form->field($model, 'branch_name') ?>

    <?= $form->field($model, 'branch_created') ?>

    <?= $form->field($model, 'branch_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
