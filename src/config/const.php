<?php

return [
    // メールアドレス正規表現
    'REGEX_EMAIL' =>
        '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+' .
        '@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/',
    // パスワード正規表現
    'REGEX_PASSWORD' => '/^[a-zA-Z0-9!-\/:-@¥\[-`{-~]+$/',
    // 日時ミリ秒正規表現
    'REGEX_DATETIME_MS' => '/^([1-9][0-9]{3})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\s' .
        '(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})' .
        '(|.[0-9]{1,6})$/',
    'ERROR' => [
        'USER' => [
            'NO_REGISTERED' => '会員登録の情報が取得できませんでした。',
            'ALREADY_REGISTERED' => 'ご入力いただいたメールアドレスはすでに登録済みです。別のメールアドレスをご入力ください。' ,
            'FAILED_REGISTERD' => '会員登録に失敗しました。',
            'LOGIN_FAILED' => 'ログインに失敗しました。メールアドレスまたはパスワードが異なります。',
            'NO_USER' => 'アカウント情報を取得できませんでした。お手数ですが、再度お試しください。',
            'PASSWORD_DIFFERENT' => 'アカウント情報を更新できませんでした。入力されたパスワードが異なります。',
            'PASSWORD_NOT_MATCH' => 'アカウント情報を更新できませんでした。再入力したパスワードが一致しません。',
            'EXISTS_EMAIL' => 'ご指定のメールアドレスは既に使用されています。',
            'FAILED_UPDATE' => 'レコードの更新に失敗しました。',
            'EMAIL_CONTAIN_UPPERCASE' => 'メールアドレスに大文字はご利用頂けません。'
        ],
    ]
];