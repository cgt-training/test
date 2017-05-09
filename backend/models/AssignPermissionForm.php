<?php
namespace backend\models;

use Yii;
use yii\base\Model;

use yii\db\Query;

/**
 * Signup form
 */
class AssignPermissionForm extends Model
{
    public $role_type;
    public $permission;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['role_type', 'trim'],
            ['role_type', 'required'],       

            ['permission','safe']
        ];
    }


    public function attributeLabels()
    {
        return [
            'role_type'=>'Role',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function assignPermission()
    {
        
       
        if (!$this->validate()) {
            return null;
        }
        $db = Yii::$app->db;
        $sql="Delete from auth_item_child where parent=:user_type";

        $db->createCommand($sql, [
            ':user_type' => $this->role_type,
        ])->execute();

        if(!empty($this->permission))
        {
            $auth = Yii::$app->authManager;

            $user_string = $auth->createRole($this->role_type);
            foreach($this->permission as $permission_string_val=>$permission_val)
            {
                $permission_string = $auth->createPermission($permission_string_val);
                $auth->addChild($user_string, $permission_string);

            }
        }
    
         return true;
        
    }
}
