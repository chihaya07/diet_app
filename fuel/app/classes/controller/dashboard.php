<?php

class Controller_Dashboard extends Controller
{
    public function before()
    {
        // ログインしていない場合はログインページへリダイレクト
        if (! \Auth::check())
        {
            \Response::redirect('login');
        }
    }

    public function action_index()
    {
        // ログインしているユーザーの情報を取得
        $user_id = \Auth::get('id'); // ★ IDを直接取得
        $username = \Auth::get('username');
        $email = \Auth::get('email');

        // ユーザーの記録を取得
        $recodes = \DB::select()
                     ->from('recodes')
                     ->where('user_id', $user_id)
                     ->order_by('record_date', 'desc')
                     ->execute()
                     ->as_array();

        // 目標体重を取得 (targetsテーブルから)
        $target_weight_query = \DB::select('target_weight')
                                ->from('targets')
                                ->where('user_id', $user_id)
                                ->order_by('monthly_at', 'desc')
                                ->limit(1)
                                ->execute()
                                ->as_array();

        $target_weight = isset($target_weight_query[0]['target_weight']) ? $target_weight_query[0]['target_weight'] : 0;

        // ビューにデータを渡す
        $data = array(
            'username' => $username,
            'email' => $email,
            'user_id' => $user_id,
            'recodes' => $recodes,
            'target_weight' => $target_weight,
        );

        // ダッシュボードのビューを読み込む
        return \View::forge('dashboard/index', $data);
    }
}