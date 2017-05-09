<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class ProfileForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $userimage;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['id', 'required'],
            ['id', 'integer'],

            ['username', 'trim'],
            ['username', 'required'],
            [['username'], 'unique',
            'targetClass' => '\common\models\User', 
            'message' => 'This username has already been taken.',
            ],
            // ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['email'], 'unique', 'on'=>'update',
            'targetClass' => '\common\models\User', 
            'message' => 'This email has already been taken.',
            ],
            // ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['userimage', 'file','extensions'=>'jpg, gif, png', 'skipOnEmpty'=>true],
            ['userimage', 'string', 'max' => 255],
           
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateProfile()
    {

       if (!$this->validate() || !empty($this->id)) {
          
            return null;
        }
        $user = User::findOne($this->id);
        $user->username = $this->username;
        $user->email = $this->email;
        if(!empty($this->userimage))
        {
            $user->userimage=$this->userimage;
        }
        
        return $user->save() ? $user : null;
    }
}
