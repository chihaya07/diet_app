<?php

class Controller_Weight extends Controller
{
    public function before()
    {
        // ログインしていない場合はログインページへリダイレクト
        if (! \Auth::check())
        {
            \Response::redirect('login');
        }
    }

    public function action_create()
    {
        $data = array();

        // POSTリクエストの場合（フォームが送信された場合）
        if (\Input::method() == 'POST')
        {
            // ここにバリデーションとデータベース保存のロジックを記述します
            // 現時点では、データをただ表示するだけにします
            $weight = \Input::post('weight');
            $record_date = \Input::post('record_date');

            $data = array(
                'weight' => $weight,
                'record_date' => $record_date,
                'message' => 'フォームが送信されました。ここから処理を開始します。'
            );

            // デバッグ用にデータをビューに渡す
            return \View::forge('weight/create', $data);
        }

        // GETリクエストの場合（初めてフォームページにアクセスした場合）
        return \View::forge('weight/create');
    }
}