<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
if(!empty($arr_permissions) && isset($user_permissions))
{
    foreach($arr_permissions as $key=> $permission)
    {
        $checked=in_array($key, $user_permissions) ? true : false;
        ?>
        <div class="col-md-4">
            <?= Html::checkbox("permission[".$key."]",$checked,[
            'label' =>  $permission,
            ])?>
        </div>

        <?php
    }
    ?>
     <div class="clearfix"></div>
    <div class="form-group">
        <?= Html::submitButton('Update',['class' =>'btn btn-success']) ?>
    </div>
    <?php
}
else
{
    echo "<h2> No Permission Found</h2>";
}
?>