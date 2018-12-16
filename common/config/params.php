<?php
return [
    'workId' => 1,
    'supportEmail' => 'admin@feehi.com',
    'user.passwordResetTokenExpire' => 3600,
    'site' => [
        'url' => 'http://cms.feehi.com',
        'sign' => '###~SITEURL~###',//数据库中保存的本站地址，展示时替换成正确url
    ],
    'admin' => [
        'url' => 'http://admin.cms.feehi.com',
    ],
    'yun_pian_api_key'=>'72c6d61838288c3ff781189bbfa5416d',
];
