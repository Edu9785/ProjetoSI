<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nome;
    public $morada;
    public $telemovel;
    public $nif;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este username já está a ser utilizador!'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['nome', 'required'],
            ['morada', 'required'],
            ['nif', 'required'],
            ['telemovel', 'required'],
            [['nome', 'morada'], 'string', 'max' => 255,],
            ['nif', 'match', 'pattern' => '/^\d{9}$/', 'message' => 'O NIF deve conter exatamente 9 números.'],
            ['telemovel', 'match', 'pattern' => '/^\d{9}$/', 'message' => 'O Telemóvel deve conter exatamente 9 números.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

            $auth = \Yii::$app->authManager;
            $utilizadorRole = $auth->getRole('utilizador');
            $auth->assign($utilizadorRole, $user->getId());

            if($user->save()){
                $profile = new Profile();
                $profile->id_user = $user->id;
                $profile->nif = $this->nif;
                $profile->morada = $this->morada;
                $profile->nome = $this->nome;
                $profile->telemovel = $this->telemovel;
                $profile->avaliacao = 0;
                $profile->save(false);

                return $user;
            }
            return $user;
        }

        return null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
