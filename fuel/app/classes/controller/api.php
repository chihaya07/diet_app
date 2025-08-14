<?php

class Controller_Api extends Controller_Rest
{
    public function get_recodes()
    {
        // ログインユーザーのIDを取得
        $user_id = \Auth::get('id');

        // ユーザーの記録を取得
        $recodes = \DB::select()
                     ->from('recodes')
                     ->where('user_id', $user_id)
                     ->order_by('record_date', 'desc')
                     ->execute()
                     ->as_array();

        // JSON形式でデータを返す
        return $this->response($recodes);
    }
}