<?php

class Model_Recode extends \Model
{
    // 記録の一覧を取得する
    public static function get_all_by_user_id($user_id)
    {
        return \DB::select()
                    ->from('recodes')
                    ->where('user_id', $user_id)
                    ->order_by('record_date', 'desc')
                    ->execute()
                    ->as_array();
    }

    // 記録をIDで取得する
    public static function get_by_id_and_user_id($id, $user_id)
    {
        return \DB::select()
                    ->from('recodes')
                    ->where('id', $id)
                    ->where('user_id', $user_id)
                    ->execute()
                    ->as_array();
    }

    // 記録を追加する
    public static function create_recode($recode_data)
    {
        list($insert_id, $rows_affected) = \DB::insert('recodes')
                                            ->set($recode_data)
                                            ->execute();
        return $rows_affected > 0;
    }

    // 記録を更新する
    public static function update_recode($id, $user_id, $recode_data)
    {
        $rows_affected = \DB::update('recodes')
                            ->set($recode_data)
                            ->where('id', $id)
                            ->where('user_id', $user_id)
                            ->execute();
        return $rows_affected > 0;
    }

    // 記録を削除する
    public static function delete_recode($id, $user_id)
    {
        $rows_affected = \DB::delete('recodes')
                            ->where('id', $id)
                            ->where('user_id', $user_id)
                            ->execute();
        return $rows_affected > 0;
    }
}