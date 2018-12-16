<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/10/21
 * Time: 13:45
 */

namespace frontend\controllers;

use backend\models\AdminUser;
use backend\models\User;
use yii;
use frontend\models\Article;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
class AuthorController extends FrontendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionView()
    {
        $param = Yii::$app->request->get();
        $query = Article::find()->where(['author_id' => $param['author_id']])->with('category');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'created_at' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'author_id' => $param['author_id'],
        ]);
    }

    public function actionGetAuthor()
    {
        return AdminUser::getAuthorSelect();
    }

    public function actionGetMoreList()
    {
        $author_id = Yii::$app->request->get('author_id');
        $authors = AdminUser::find()
            ->where(['type' => 1])
            ->andWhere(['status' => User::STATUS_ACTIVE])
//            ->andWhere(['>', 'id', $author_id])
            ->limit(24)
            ->all();
        $array =[];
        foreach ($authors as $author) {
            if (strlen($author->introduce) > 90) {
                $introduce = substr($author->introduce, 0, 90) . "...";
            } else {
                $introduce = $author->introduce;
            }
            $row = [];
            $as = Article::find()
                ->where(['type' => Article::ARTICLE])
//                ->andWhere(['author_id' => $author_id])
                ->andWhere(['status' => Article::ARTICLE_PUBLISHED])
                ->orderBy('created_at DESC')
                ->limit(3)
                ->all();
            foreach ($as as $a) {
                $row[]=[
                    'id'=>$a->id,
                    'title'=>$a->title,
                ];
            }
            $array[]=[
                'author_id'=>$author->id,
                'avatar'=>$author->avatar ,
                'username'=>$author->username,
                'introduce'=>mb_convert_encoding($introduce,"UTF-8" ) ,
                'a'=>$row
            ];
            unset($row);
        }
       return $array;
    }

    /**
     * 这个是检查前台用户是否注册！！！
     * @return bool
     */
    public function actionCheckRegister(){
        $data=Yii::$app->request->get();
        if (\frontend\models\User::findOne(['telephone'=>$data["telephone"]])!=null) {
            return true;
        }
        return false;
    }
}