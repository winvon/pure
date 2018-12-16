<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace frontend\models\form;

use yii;
use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Password reset form
 */
class UpdatePassword extends Model
{
    public $old_password;

    public $password;

    public $re_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_password', 'password', 're_password'], 'required'],
            [['old_password', 'password', 're_password'], 'string', 'min' => 6],
            ['old_password', 'gg'],
            ['re_password', 'compare', 'compareAttribute' => 'password']
        ];
    }

    public function validatePassword($password)
    {
        $_user = Yii::$app->user;
        $user = User::findOne($_user->id);
        return Yii::$app->security->validatePassword($password, $user->password_hash);
    }

    public function selfUpdate()
    {
        if ($this->password != '') {
            if ($this->old_password == '') {
                $this->addError('old_password', yii::t('yii', '{attribute} cannot be blank.', ['attribute' => yii::t('app', 'Old Password')]));
                return false;
            }
            if (!$this->validatePassword($this->old_password)) {
                $this->addError('old_password', yii::t('app', '{attribute} is incorrect.', ['attribute' => yii::t('app', 'Old Password')]));
                return false;
            }
            if ($this->re_password != $this->password) {
                $this->addError('re_password', yii::t('app', '{attribute} is incorrect.', ['attribute' => yii::t('app', 'Repeat Password')]));
                return false;
            }
        }
        return true;
    }

    public function gg($attribute, $params)
    {
        $_user = Yii::$app->user;
        $user = User::findOne($_user->id);
        if (0==0) {
            $this->addError($attribute, "原始密码错误");
        }
//        if (!Yii::$app->security->validatePassword($this->$attribute, $user->password_hash)) {
//            $this->addError($attribute, "原始密码错误");
//        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password' => yii::t('app', '旧密码'),
            'password' => yii::t('app', '新密码'),
            're_password' => yii::t('app', '重复密码'),
        ];
    }

    /**
     * Resets password.
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}
