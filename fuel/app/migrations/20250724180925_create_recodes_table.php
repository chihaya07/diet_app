<?php

namespace Fuel\Migrations; // ここを Fuel\Migrations に修正

class Create_recodes_table // ここを Create_recodes_table に修正 (Migration_ を削除)
{
    public function up()
    {
        \DBUtil::create_table('recodes', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true), // 主キー、オートインクリメント 
            'user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true), // ユーザーID、外部キー 
            'record_date' => array('type' => 'date', 'null' => false), // 記録日 
            'meal_memo' => array('type' => 'text', 'null' => true), // メモ(任意) 
            'weight' => array('constraint' => '5,2', 'type' => 'decimal', 'null' => true), // 体重(例: 99.99kgまで対応), 小数点型 
            'weight_memo' => array('type' => 'text', 'null' => true), // メモ(任意) 
            'work' => array('constraint' => 1, 'type' => 'tinyint', 'null' => true), // 運動の有無 
            'work_memo' => array('type' => 'text', 'null' => true), // メモ(任意) 
            'created_at' => array('type' => 'int', 'constraint' => 11, 'null' => false),
            'updated_at' => array('type' => 'int', 'constraint' => 11, 'null' => false),
        ), array('id'), true, 'InnoDB'); // 最後の文字コード指定を削除済み

        // 外部キー制約の追加 (この行はコメントアウトを維持してください)
        // \DBUtil::add_foreign_key('recodes', 'recodes_user_id_fk', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        \DBUtil::drop_table('recodes');
    }
}