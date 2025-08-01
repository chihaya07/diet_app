<?php

class Controller_Dashboard extends Controller
{
    public function action_index()
    {
        // ログインしていない場合はログインページへリダイレクト
        if (! \Auth::check())
        {
            \Response::redirect('login');
        }

        // ログインしているユーザー情報を取得
        $current_user = \Auth::get_user_id(); // これは配列で [0 => user_id, 1 => group_id] が返る
        $user_id = $current_user[0]; // ユーザーIDを取得
        $username = \Auth::get('username'); // ユーザー名を取得（Auth設定による）
        $email = \Auth::get('email'); // メールアドレスを取得（Auth設定による）

        // ビューにデータを渡す
        $data = array(
            'username' => $username,
            'email' => $email,
            'user_id' => $user_id,
        );

        // ダッシュボードのビューを読み込む
        return \View::forge('dashboard/index', $data);
    }
}