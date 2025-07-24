<?php

namespace Fuel\Migrations; // ここを Fuel\Migrations に修正

class Create_targets_table // ここを Create_targets_table に修正 (Migration_ を削除)
{
    public function up()
    {
        \DBUtil::create_table('targets', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true), // 主キー、オートインクリメント 
            'user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true), // ユーザーID、外部キー 
            'target_weight' => array('constraint' => '5,2', 'type' => 'decimal', 'null' => true), // 目標体重(例:99.99kgまで対応),小数点型 
            'target_work' => array('constraint' => 11, 'type' => 'int', 'null' => true), // 目標運動回数 
            'monthly_at' => array('type' => 'date', 'null' => true), // 目標設定(月) 
            'created_at' => array('type' => 'datetime', 'null' => false), // 作成日時 
            'updated_at' => array('type' => 'datetime', 'null' => false), // 更新日時 
        ), array('id'), true, 'InnoDB'); // 最後の文字コード指定を削除済み

        // 外部キー制約の追加 (この行はコメントアウトを維持してください)
        // \DBUtil::add_foreign_key('targets', 'targets_user_id_fk', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        \DBUtil::drop_table('targets');
    }
}