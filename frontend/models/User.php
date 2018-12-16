<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 10:30
 */

namespace frontend\models;

use yii;
use common\helpers\Util;

;

class User extends \common\models\User
{

    public $password;

    public $repassword;

    public $old_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'repassword', 'password_hash'], 'string'],
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            [['repassword'], 'compare', 'compareAttribute' => 'password'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'email', 'password', 'repassword'], 'required', 'on' => ['create']],
            [['old_password', 'password', 'repassword'], 'required', 'on' => ['self-update']],
            [[ 'password'], 'safe', 'on' => ['forget-password']],
            [['old_password', 'password', 'repassword'], 'string', 'min' => 6],
//            ['old_password','checkOldPassword','on' => ['self-update']],
            [['username', 'email'], 'required', 'on' => ['update']],
        ];
    }

    public function checkOldPassword($attribute, $params)
    {
        if (!$this->validatePassword($this->old_password)) {
            $this->addError($attribute, '原始密码错误'.$this->old_password);
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['username', 'email', 'password', 'avatar', 'repassword', 'status'],
            'update' => ['username', 'email', 'password', 'repassword', 'avatar', 'status'],
            'self-update' => ['username', 'email', 'password', 'repassword', 'old_password', 'avatar'],
            'forget-password' => ['password','password_hash'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => yii::t('app', 'Username'),
            'email' => yii::t('app', 'Email'),
            'old_password' => yii::t('app', 'Old Password'),
            'password' => yii::t('app', 'Password'),
            'repassword' => yii::t('app', 'Repeat Password'),
            'avatar' => yii::t('app', 'Avatar'),
            'status' => yii::t('app', 'Status'),
            'created_at' => yii::t('app', 'Created At'),
            'updated_at' => yii::t('app', 'Updated At'),
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => yii::t('app', 'Normal'),
            self::STATUS_DELETED => yii::t('app', 'Disabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
            $this->generateAuthKey();
            $this->setPassword($this->password);
            $this->updated_at = 0;
        } else {
            $this->updated_at = time();
            if (isset($this->password) && $this->password != '') {
                if ($this->getScenario() == 'self-update') {
                    if ($this->old_password == '') {
                        $this->addError('old_password', 'Old password cannot be blank.');
                        return false;
                    }
                    if (!$this->validatePassword($this->old_password)) {
                        $this->addError('old_password', '旧密码错误');
                        return false;
                    }
                } else {
                    if ($this->getScenario() == 'update') {
                        if ($this->repassword == '') {
                            $this->addError('repassword', 'repassword cannot be blank.');
                            return false;
                        }
                    }
                }
                $this->setPassword($this->password);
            }
        }
        Util::handleModelSingleFileUpload($this, 'avatar', $insert, '@frontend/web/uploads/avatar/');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function updatePassword()
    {
        return $this->save();
    }

}