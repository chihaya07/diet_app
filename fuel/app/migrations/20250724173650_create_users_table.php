<?php

namespace Fuel\Migrations;

class Create_users_table
{
    public function up()
    {
        \DBUtil::create_table('users', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true), // 主キー、オートインクリメント
            'username' => array('constraint' => 50, 'type' => 'varchar', 'unique' => true, 'null' => false), // ユーザー名, UNIQUE, NOT NULL
            'email' => array('constraint' => 255, 'type' => 'varchar', 'unique' => true, 'null' => false), // メールアドレス, UNIQUE, NOT NULL, ログインIDとして使用
            'password' => array('constraint' => 255, 'type' => 'varchar', 'null' => false), // パスワード(ハッシュ化して保存), NOT NULL
            'created_at' => array('type' => 'datetime', 'null' => false), // 作成日時
            'updated_at' => array('type' => 'datetime', 'null' => false), // 更新日時
        ), array('id'), true, 'InnoDB');
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}