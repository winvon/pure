<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-31 15:01
 */

namespace backend\controllers;


use backend\models\AdminUser;
use yii;
use backend\models\form\PasswordResetRequestForm;
use backend\models\form\ResetPasswordForm;
use backend\models\User;
use backend\models\search\UserSearch;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use backend\actions\ViewAction;

class AdminUserController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function () {
                    $searchModel = new UserSearch();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];
                }
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'modelClass' => User::className(),
            ],
            'view' => [
                'class' => ViewAction::className(),
                'modelClass' => User::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => User::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => User::className(),
            ],
        ];
    }

    /**
     * 创建管理员账号
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario('create');
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['index']);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new User();
        $model->setScenario('signup');
        if ($model->load(Yii::$app->getRequest()->post())) {
            $model->roles=['导师'];
            $model->district=Yii::$app->cache->get($model->telephone.'district');
            $model->permissions=[];
            if ($model->save()&&$model->assignPermission()) {
                Yii::$app->user->login($model);
                Yii::$app->getSession()->setFlash('success', '注册成功');
                return $this->redirect(['site/index']);
            }else{
                return $this->render('signup', [
                    'model' => $model,
                ]);
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);

    }

    /**
     * 审核
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionCheck($id)
    {
        $model = User::findOne($id);
        $model->setScenario('check');
        if (Yii::$app->getRequest()->getIsPost()) {
            if ($model->load(Yii::$app->request->post()) && $model->save() ) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['check', 'id' => $model->getPrimaryKey()]);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        }
        return $this->render('check', [
            'model' => $model,
        ]);
    }

    /**
     * 修改管理员账号
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = User::findOne($id);
        $model->setScenario('update');
        if (Yii::$app->getRequest()->getIsPost()) {
            if ($model->load(Yii::$app->request->post()) && $model->save() ) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['update', 'id' => $model->getPrimaryKey()]);
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 登陆的管理员修改自身
     *
     * @return string
     */
    public function actionUpdateSelf()
    {
        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('self-update');
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(yii::$app->getRequest()->post()) && $model->selfUpdate()) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionChangeImportant()
    {
        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('change-important');
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(yii::$app->getRequest()->post())) {
                $model->admin_status=AdminUser::STATUS_ADMIN_CHECK;
                $model->save();
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        }
        return $this->render('change-important', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('change-password');
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(yii::$app->getRequest()->post()) && $model->changePassword()) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        }
        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionChangeNotImportant()
    {
        $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('change-not-important');
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(yii::$app->getRequest()->post()) && $model->selfUpdate()) {
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            } else {
                $errors = $model->getErrors();
                $err = '';
                foreach ($errors as $v) {
                    $err .= $v[0] . '<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id' => yii::$app->getUser()->getIdentity()->getId()]);
        }
        return $this->render('change-not-important', [
            'model' => $model,
        ]);
    }


    /**
     * 管理员输入邮箱重置密码
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()
                    ->setFlash('success', yii::t('app', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()
                    ->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * 管理员重置密码
     *
     * @param $token
     * @return string|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', yii::t('app', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}