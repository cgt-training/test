<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class AuthPermissionForm extends Model
{
    public $auth_type;
    public $auth_title;
    public $auth_description;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['auth_type', 'trim'],
            ['auth_type', 'required'],
            ['auth_type', 'integer'],

            ['auth_title', 'trim'],
            ['auth_title', 'required'],
            ['auth_title', 'string', 'min' => 4, 'max' => 255],

            ['auth_description', 'trim'],
            ['auth_description', 'string','min' => 4, 'max' => 255],
          
        ];
    }


    public function attributeLabels()
    {
        return [
            'auth_type'=>'Type',
            'auth_title' => 'Title',
            'auth_description' => 'Description',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function createauth()
    {
        

        if (!$this->validate()) {
            return null;
        }

        $auth = Yii::$app->authManager;

        

        if($this->auth_type=="1")
        {
            $create = $auth->createRole($this->auth_title);
        }
        else
        {
            $create = $auth->createPermission($this->auth_title);
        }
         $create->description = $this->auth_description;

         return $auth->add($create) ? $auth : null;
        
    }
}
