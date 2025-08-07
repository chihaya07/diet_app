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
        $user_id = \Auth::get('id');
        $username = \Auth::get('username');
        $email = \Auth::get('email');

        // フィルタリングとソートのパラメータを取得
        $start_date = \Input::get('start_date');
        $end_date = \Input::get('end_date');
        $sort_by = \Input::get('sort_by', 'record_date'); // デフォルトは記録日
        $sort_order = \Input::get('sort_order', 'desc'); // デフォルトは降順

        // ユーザーの記録を取得するためのクエリビルダ
        $query = \DB::select()
                    ->from('recodes')
                    ->where('user_id', $user_id);

        // 日付によるフィルタリング
        if (!empty($start_date)) {
            $query->where('record_date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $query->where('record_date', '<=', $end_date);
        }

        // ソート
        $query->order_by($sort_by, $sort_order);

        $recodes = $query->execute()->as_array();

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
            'start_date' => $start_date, // フィルタリングフォームに値を戻すために追加
            'end_date' => $end_date,     // フィルタリングフォームに値を戻すために追加
            'sort_by' => $sort_by,       // ソートリンクをアクティブにするために追加
            'sort_order' => $sort_order, // ソートリンクをアクティブにするために追加
        );

        // ダッシュボードのビューを読み込む
        return \View::forge('dashboard/index', $data);
    }
}