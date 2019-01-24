<?php

namespace frontend\controllers;

use Yii;
use backend\models\search\ActionSearch;
use frontend\models\Action;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;

/**
 * ActionController implements the CRUD actions for Action model.
 */
class ActionController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function () {

                    $searchModel = new ActionSearch();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],
//            'create' => [
//                'class' => CreateAction::className(),
//                'modelClass' => Action::className(),
//            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Action::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Action::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Action::className(),
            ],
        ];
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            yii::$app->getSession()->setFlash('error', yii::t('app', '请先登录！'));
            return $this->redirect(['site/login']);
        }
        $model = Action::find()->where(['uid' => Yii::$app->user->id])->one();
        if (Yii::$app->request->get('lo') == 1 && $model != null) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
        if ($model != null) {
            yii::$app->getSession()->setFlash('error', yii::t('app', '您已报名！'));
            return $this->redirect(['update', 'id' => $model->id]);
        }
        $model = new Action();
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(yii::$app->getRequest()->post()) && $model->save()) {
                for ($i = 0; $i < 3; $i++) {
                    if ($this->send($model->email,$model->num)) {
                        break;
                    }
                }
                yii::$app->getSession()->setFlash('success', yii::t('app', '活动报名成功,可前往我的活动查看'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                $errorReasons = $model->getErrors();
                $err = '';
                foreach ($errorReasons as $errorReason) {
                    $err .= $errorReason[0] . '<br>';
                }
                $err = rtrim($err, '<br>');
                yii::$app->getSession()->setFlash('error', $err);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function send($email, $num)
    {
        $content = '<div>
            <h3>恭喜您已报名成功</h3>
            <p style="font-size: 12px">恭喜您已报名成功，报名编号：' . $num . '，若需修改资料，请登陆到www.purelove.ltd 【我的报名】 修改报名讯息。</p>
            <p style="font-size: 12px">缴费之后请email负责人,或者回复本邮件已缴费。回复内容包含您的的报名编号或者电话号码或者微信号码。</p>
            <p>报名缴费各地区负责人账户及邮箱</p>
            <div class="div-box" style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>馬來西亞负责人：靜娟</p>
                <p>*入账银行：馬來亞銀行（Maybank）</p>
                <p>*账号姓名：Tu Chin Juan</p>
                <p>*账号号码：1010-6781-6041</p>
                <p>*Email ： ginger.tu@gmail.com</p>
                <p>*通讯电话 ：+6012-7886553</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>新加坡负责人：林潔馨 Jacelyn Lim</p>
                <p>*入账银行：Oversea-Chinese Banking (OCBC)</p>
                <p>*账号姓名： Lim Gat Sin</p>
                <p>*账号号码：608053294001</p>
                <p>*Email : jaceljx@gmail.com</p>
                <p>*通讯电话 ：+65-83992648</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>台湾台北负责人</p>
                <p>*入账银行：中國信託銀行(chinatrust)</p>
                <p>*账号号码：帳戶：822-277531011281</p>
                <p>*中文名字：丁竑峻 </p>
                <p>* Email ：frederic123123123123@gmail.com</p>
                <p>*通讯电话 ：+886-922-491707</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>北京|深圳|香港|澳门负责人</p>
                <p>子漩老師 </p>
                <p>* 入账银行：恒生銀行 </p>
                <p>* 账号号码：936 050855 888</p>
                <p>* 中文名字：张子漩 </p>
                <p>* 英文姓名：Cheung Tsz Suen </p>
                <p>*通讯电话 ：+855-66293812</p>
                <p>*通讯电话 ：+86-13728987573</p>
            </div>
        </div>';
        $res = Yii::$app->mailer->compose()
            ->setFrom('1165180201@qq.com')
            ->setTo($email)
            ->setSubject('阿卡西课程报名')
            ->setTextBody('Plain text content')
            ->setHtmlBody($content)
            ->send();
        var_dump($res);
    }
}
