<?php
return array(
    'driver' => 'Simpleauth', // これが Simpleauth になっていることを確認

    'salt' => 'oaliefiagoiaroufgh983oiw93293o4ph9', // 例: 'g8h7j6k5l4m3n2b1v0c9x8z7a6s5d4f3'

    'verify_multiple_logins' => true,
    'salt_last_user_hash' => false,

    'table_name' => 'users', // users テーブルを参照していることを確認

    // ユーザーテーブルのカラムマッピング
    'db_column_name' => array(
        'username'    => 'username', // ユーザー名カラム
        'password'    => 'password', // パスワードカラム
        'email'       => 'email',    // メールアドレスカラム
        'last_login'  => 'last_login',
        'login_hash'  => 'login_hash',
        'group'    => 'group',
        'profile_fields' => 'profile_fields', // プロフィールフィールド用のカラム（通常はTEXT型）
        'activated'   => 'activated',
        'new_password' => 'new_password',
        'remember_me'  => 'remember_me',
        'confirmation_key' => 'confirmation_key',
        'reset_hash'  => 'reset_hash',
        'created_at'  => 'created_at',
        'updated_at'  => 'updated_at',
    ),
);
