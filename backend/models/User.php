<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\models;

use backend\components\CustomLog;
use common\helpers\Util;
use Yii;
use yii\base\Event;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use \yii\web\ForbiddenHttpException;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $nickname
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $telephone
 * @property string $auth_key
 * @property string $introduce
 * @property integer admin_status
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_ADMIN_CHECK = 1;
    const STATUS_ADMIN_PASS = 2;
    const STATUS_ADMIN_PASS_NOT = 3;

    const TYPE_MANAGE = 0;
    const TYPE_TEACHER = 1;

    public $password;

    public $repassword;

    public $code;

    public $old_password;

    public $roles;

    public $permissions;

    /**
     * 返回数据表名
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'repassword', 'password_hash'], 'string'],
            ['email', 'email'],
            [
                'telephone',
                'unique',
                'targetClass' => User::className(),
                'message' => yii::t('app', 'This telephone has already been taken'),
                'on' => ['create', 'signup', 'update', 'change-not-important']
            ],
            [
                'username',
                'unique',
                'targetClass' => User::className(),
                'message' => yii::t('app', 'This username has already been taken')
            ],
            ['telephone', 'filter', 'filter' => 'trim'],
            [['repassword'], 'compare', 'compareAttribute' => 'password'],
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['telephone', 'password', 'code'], 'required', 'on' => ['forget-password']],
            [['username', 'telephone', 'password', 'repassword'], 'required', 'on' => ['create']],
            [['username', 'password', 'code', 'telephone'], 'required', 'on' => ['signup']],
            [['username', 'code', 'telephone'], 'required', 'on' => ['update']],
            [['username'], 'unique', 'on' => 'create'],
            [['roles', 'permissions', 'sign', 'introduce', 'admin_status', 'reason', 'nickname', 'district'], 'safe'],
            ['code', 'checkCode'],
            [['telephone', 'realname', 'card_number', 'bank', 'bank_account', 'current_address'], 'required', 'on' => 'self-update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['username', 'email'],
            'create' => ['username', 'telephone', 'password', 'avatar', 'status', 'roles', 'permissions'],
            'forget-password' => ['telephone', 'password', 'code'],
            'signup' => ['username', 'telephone', 'code', 'password', 'avatar', 'status', 'roles', 'permissions', 'district'],
            'update' => ['username', 'email', 'password', 'sign', 'introduce', 'avatar', 'status', 'roles', 'permissions'],
            'self-update' => [
                'username', 'telephone', 'sign',
                'introduce', 'nickname', 'realname',
                'card_number', 'bank', 'bank_account',
                'card_img', 'current_address', 'certificate', 'avatar',
            ],
            'change-not-important' => [
                'telephone', 'sign',
                'introduce', 'nickname', 'current_address', 'avatar',
            ],
            'change-important' => [
                'realname', 'card_number', 'card_img', 'bank', 'bank_account', 'certificate', 'admin_status',
            ],
            'change-password' => ['password', 'old_password', 'repassword'
            ],
            'check' => ['password', 'admin_status', 'reason'],
        ];
    }

    public function checkCode($attribute)
    {
        if (!$this->hasErrors()) {
            $cache = Yii::$app->cache;
            if ($cache->get($this->telephone) != $this->code) {
                $this->addError($attribute, yii::t('app', '验证码错误'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => yii::t('app', 'Username'),
            'realname' => yii::t('app', '真实姓名'),
            'card_number' => yii::t('app', '身份证件号码'),
            'bank' => yii::t('app', '开户银行'),
            'bank_account' => yii::t('app', '开户银行账号'),
            'card_img' => yii::t('app', '身份证件凭证'),
            'current_address' => yii::t('app', '常居地址'),
            'certificate' => yii::t('app', '专业凭证'),
            'nickname' => yii::t('app', 'Nickname'),
            'sign' => yii::t('app', 'Person Sign'),
            'code' => yii::t('app', '验证码'),
            'introduce' => yii::t('app', 'Introduce'),
            'telephone' => yii::t('app', 'Telephone'),
            'district' => yii::t('app', '地区'),
            'old_password' => yii::t('app', 'Old Password'),
            'password' => yii::t('app', 'Password'),
            'repassword' => yii::t('app', 'Repeat Password'),
            'avatar' => yii::t('app', 'Avatar'),
            'status' => yii::t('app', 'Status'),
            'admin_status' => yii::t('app', 'Status'),
            'created_at' => yii::t('app', 'Created At'),
            'updated_at' => yii::t('app', 'Updated At'),
            'reason' => yii::t('app', '原因')
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => yii::t('app', 'Normal'),
            self::STATUS_DELETED => yii::t('app', 'Disabled'),
        ];
    }

    public static function getAdminStatuses()
    {
        return [
            self::STATUS_ADMIN_CHECK => yii::t('app', '待审核'),
            self::STATUS_ADMIN_PASS => yii::t('app', '通过'),
            self::STATUS_ADMIN_PASS_NOT => yii::t('app', '拒绝'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => AdminUser::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        Util::handleModelSingleFileUpload($this, 'avatar', $insert, '@admin/uploads/avatar/');
        Util::handleModelSingleFileUpload($this, 'card_img', $insert, '@admin/uploads/card_img/');
        Util::handleModelSingleFileUpload($this, 'certificate', $insert, '@admin/uploads/certificate/');
        if ($insert) {
            $this->generateAuthKey();
            $this->setPassword($this->password);
            empty($this->avater) ? $this->avatar = '/admin/uploads/avatar/' . rand(1, 10) . '.jpg' : '';
        } else {
            if (isset($this->password) && $this->password != '') {
                $this->setPassword($this->password);
            }
        }
        if ($this->admin_status == self::STATUS_ADMIN_PASS_NOT) {
            $user = Yii::$app->user;
            if (empty($this->reason) && $user->identity->type == self::TYPE_MANAGE) {
                $this->addError('reason', '审核不通过,拒绝原因必填');
                return false;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->avatar) {
            /** @var TargetAbstract $cdn */
            $cdn = yii::$app->get('cdn');
            $this->avatar = $cdn->getCdnUrl($this->avatar);
        }
        if ($this->card_img) {
            /** @var TargetAbstract $cdn */
            $cdn = yii::$app->get('cdn');
            $this->card_img = $cdn->getCdnUrl($this->card_img);
        }
        if ($this->certificate) {
            /** @var TargetAbstract $cdn */
            $cdn = yii::$app->get('cdn');
            $this->certificate = $cdn->getCdnUrl($this->certificate);
        }
    }


    public function assignPermission()
    {
        $authManager = yii::$app->getAuthManager();
        if (!$this->getIsNewRecord() && in_array($this->id, yii::$app->getBehavior('access')->superAdminUserIds)) {
            $this->permissions = $this->roles = [];
        }
        $assignments = $authManager->getAssignments($this->id);
        $roles = $permissions = [];
        foreach ($assignments as $key => $assignment) {
            if (strpos($assignment->roleName, ':GET') || strpos($assignment->roleName, ':POST')) {
                $permissions[$key] = $assignment;
            } else {
                $roles[$key] = $assignment;
            }
        }
        $roles = array_keys($roles);
        $permissions = array_keys($permissions);

        $str = '';

        //角色roles
        if (!is_array($this->roles)) $this->roles = [];
        $needAdds = array_diff($this->roles, $roles);
        $needRemoves = array_diff($roles, $this->roles);
        if (!empty($needAdds)) {
            $str .= " 增加了角色: ";
            foreach ($needAdds as $role) {
                $roleItem = $authManager->getRole($role);
                $authManager->assign($roleItem, $this->id);
                $str .= " {$roleItem->name},";
            }
        }
        if (!empty($needRemoves)) {
            $str .= ' 删除了角色: ';
            foreach ($needRemoves as $role) {
                $roleItem = $authManager->getRole($role);
                $authManager->revoke($roleItem, $this->id);
                $str .= " {$roleItem->name},";
            }
        }

        //权限permission
        $this->permissions = array_flip($this->permissions);
        if (isset($this->permissions[0])) unset($this->permissions[0]);
        $this->permissions = array_flip($this->permissions);

        $needAdds = array_diff($this->permissions, $permissions);
        $needRemoves = array_diff($permissions, $this->permissions);
        if (!empty($needAdds)) {
            $str .= ' 增加了权限: ';
            foreach ($needAdds as $permission) {
                $permissionItem = $authManager->getPermission($permission);
                $authManager->assign($permissionItem, $this->id);
                $str .= " {$permissionItem->name},";
            }
        }
        if (!empty($needRemoves)) {
            $str .= ' 删除了权限: ';
            foreach ($needRemoves as $permission) {
                $permissionItem = $authManager->getPermission($permission);
                $authManager->revoke($permissionItem, $this->id);
                $str .= " {$permissionItem->name},";
            }
        }
        Event::trigger(CustomLog::className(), CustomLog::EVENT_CUSTOM, new CustomLog([
            'sender' => $this,
            'description' => "修改了 用户(uid {$this->id}) {$this->username} 的权限: {$str}",
        ]));
        return true;
    }

    /**
     * @inheritdoc
     */
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
            if ($this->repassword != $this->password) {
                $this->addError('repassword', yii::t('app', '{attribute} is incorrect.', ['attribute' => yii::t('app', 'Repeat Password')]));
                return false;
            }
        }
        return $this->save();
    }

    public function changePassword()
    {
        if ($this->old_password == '') {
            $this->addError('old_password', yii::t('yii', '{attribute} cannot be blank.', ['attribute' => yii::t('app', 'Old Password')]));
            return false;
        }
        if (!$this->validatePassword($this->old_password)) {
            $this->addError('old_password', yii::t('app', '{attribute} is incorrect.', ['attribute' => yii::t('app', 'Old Password')]));
            return false;
        }
        if ($this->repassword != $this->password) {
            $this->addError('repassword', yii::t('app', '{attribute} is incorrect.', ['attribute' => yii::t('app', 'Repeat Password')]));
            return false;
        }
        return $this->save();
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if ($this->id == 1) {
            throw new ForbiddenHttpException(yii::t('app', "Not allowed to delete {attribute}", ['attribute' => yii::t('app', 'default super administrator admin')]));
        }
        return true;
    }

    public function getRolesName()
    {
        if (in_array($this->getId(), yii::$app->getBehavior('access')->superAdminUserIds)) {
            return [yii::t('app', 'System')];
        }
        $role = array_keys(yii::$app->getAuthManager()->getRolesByUser($this->getId()));
        if (!isset($role[0])) return [];
        return $role;
    }


    public function getRolesNameString($glue = ',')
    {
        $roles = $this->getRolesName();
        $str = '';
        foreach ($roles as $role) {
            $str .= yii::t('menu', $role) . $glue;
        }
        return rtrim($str, $glue);
    }

    public static function getQuery()
    {
        $param = Yii::$app->request->get();
        $model = new self();
        $model->attributes = $param;

        return self::find()
            ->andFilterWhere(['like', 'username', $model->username])
            ->orFilterWhere(['like', 'nickname', $model->username]);
    }

    public static function getAuthor()
    {
        return self::getQuery()
            ->andFilterWhere(['type' => 1])
            ->all();
    }


}

