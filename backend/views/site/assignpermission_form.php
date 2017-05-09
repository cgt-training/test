<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = 'Assign Permission';
?>
<div class="auth-create">

    <h1><?= Html::encode($this->title) ?></h1>

  <div class="auth-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_type')->dropDownList($arr_roles,['prompt'=>"Select Role",
        'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/permissions?id=').'"+$(this).val(), function( data ) {
              $( "#permission_block" ).html( data );
            });'
    ]); ?>
    <div id='permission_block' class='form-group'>

    </div>
    

    <?php ActiveForm::end(); ?>

</div>

</div>
