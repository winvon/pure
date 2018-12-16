<?php
use yii\helpers\Url;

?>
<footer class="footer">
    <div class="footer-inner">
        <ul id="menu-page" class="top-menu">
            <a target="_blank"
               href="<?= Url::to(['page/view', 'name' => 'about']) ?>"><?= yii::t('frontend', 'About us') ?></a>
            |
            <a target="_blank"
               href="<?= Url::to(['page/view', 'name' => 'contact']) ?>"><?= yii::t('frontend', 'Contact us') ?></a>
        </ul>
        <p>
            <a href="http://www.feehi.com/" title="Feehi CMS">Feehi
                CMS</a> <?= yii::t('frontend', 'Copyright, all rights reserved') ?> © 2015-<?= date('Y') ?>&nbsp;&nbsp;
            <select onchange="location.href=this.options[this.selectedIndex].value;" style="height: 30px">
                <option <?php if (yii::$app->language == 'zh-CN') {
                    echo 'selected';
                } ?> value="<?= Url::to(['site/language', 'lang' => 'zh-CN']) ?>">简体中文
                </option>
                <option <?php if (yii::$app->language == 'en-US') {
                    echo "selected";
                } ?> value="<?= Url::to(['site/language', 'lang' => 'en-US']) ?>">English
                </option>
            </select>
        </p>
        <p><?= yii::$app->feehi->website_icp ?> Powered by Feehi CMS <a title="飞嗨" target="_blank"
                                                                        href="http://blog.feehi.com">飞嗨</a></p>
    </div>
</footer>