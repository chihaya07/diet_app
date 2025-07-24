<?php
/**
 * The development database settings.
 */

return array(
    'default' => array(
        'connection'  => array(
            'hostname'   => 'db',        // Docker Composeサービス名 (dbサービス)
            'port'       => '3306',      // コンテナ内部のMySQLポート
            'database'   => 'chihaya_db',// docker-compose.yml で設定したデータベース名
            'username'   => 'root',      // docker-compose.yml で設定したユーザー名
            'password'   => 'root',      // docker-compose.yml で設定したパスワード
        ),
    ),
);