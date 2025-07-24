<?php
/**
 * Use this file to override common defaults.
 *
 * In a production environment, you would use config/db.production.php
 * (the name of which is defined in fuel/app/bootstrap.php, default is production)
 *
 * You should *never* include this file in your version control system.
 */

return array(
    // Default connection
    'default' => array(
        'type'        => 'mysqli',
        'connection'  => array(
            'hostname'   => 'db',        // Docker Composeサービス名 (dbサービス)
            'port'       => '3306',      // コンテナ内部のMySQLポート
            'database'   => 'chihaya_db',// docker-compose.yml で設定したデータベース名
            'username'   => 'root',      // docker-compose.yml で設定したユーザー名
            'password'   => 'root',      // docker-compose.yml で設定したパスワード
            'persistent' => false,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'collation'    => 'utf8_general_ci',
        'profiling'    => false,
    ),
);