<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $userimage;
    public $role;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id','safe'],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['userimage', 'file','extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
            ['userimage', 'string', 'max' => 255],
            ['userimage', 'safe'],

            ['role', 'required'],
            ['role', 'string', 'max' => 255],
           
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'userimage' => 'Image',
            'role'=>'Role'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function saveUser()
    {
        
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->userimage=empty($this->userimage) ? '' : $this->userimage;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
