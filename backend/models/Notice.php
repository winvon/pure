<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/11/4
 * Time: 12:44
 */

namespace backend\models;
use common\models\BaseModel;
use Yii;

class Notice extends \common\models\Notice
{

    public $content = null;
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->content = str_replace(Yii::getAlias('@frontend/web'), '', $this->content);//图片
        if ($insert) {
            $this->id=self::getId();
            $this->created_at = time();
        } else {
            $this->updated_at = time();
        }
        $this->deadline_at=strtotime($this->deadline_at);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $contentModel = new ArticleContent();
            $contentModel->aid = $this->id;
        } else {
            if ($this->content === null) {
                return;
            }
            $contentModel = ArticleContent::findOne(['aid' => $this->id]);
            if ($contentModel == null) {
                $contentModel = new ArticleContent();
                $contentModel->aid = $this->id;
            }
        }
        $contentModel->content = $this->content;
        $contentModel->save();
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->content = ArticleContent::findOne(['aid' => $this->id])['content'];
        $this->deadline_at = date('Y-m-d H:i',$this->deadline_at);
    }
}