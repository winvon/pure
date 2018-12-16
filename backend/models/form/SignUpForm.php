<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */
namespace backend\models\form;

use yii;
use yii\base\Model;
use backend\models\User;

/**
 * Login form
 */
class SignUpForm extends Model
{
    public $username;

    public $password;

    public $telephone;

    public $code;

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['username', 'filter', 'filter' => 'trim'],
            ['telephone', 'filter', 'filter' => 'trim'],
            [['username', 'password','telephone','code'], 'required'],
            [
                'username',
                'unique',
                'targetClass' => User::className(),
                'message' => yii::t('app', 'This username has already been taken')
            ],
            [
                'telephone',
                'unique',
                'targetClass' => User::className(),
                'message' => yii::t('app', 'This telephone has already been taken')
            ],
            ['code', 'checkCode'],
            /*[
                'captcha',
                'captcha',
                'captchaAction' => 'site/captcha',
                'message' => yii::t('app', 'Verification code error.')
            ],*/
            ['telephone', 'filter', 'filter' => 'trim'],
            ['telephone', 'required'],
            ['telephone','match','pattern'=>'/^[1][34578][0-9]{9}$/'],
            ['telephone', 'string', 'max' => 20],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function checkCode($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $cache=Yii::$app->cache;
            if ($cache->get($this->telephone)!=$this->code) {
                $this->addError($attribute, yii::t('app','Mobile verification code error'));
            }
        }
    }



    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => yii::t('app', 'Username'),
            'password' => yii::t('app', 'Password'),
            'telephone' => yii::t('app', 'Telephone'),
            'code' => yii::t('app', 'Telephone Code'),
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->telephone = $this->telephone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}
