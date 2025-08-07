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

    public function action_edit($id = null)
    {
        // レコードが存在するか確認
        $recode_query = \DB::select()
                            ->from('recodes')
                            ->where('id', $id)
                            ->where('user_id', \Auth::get('id'))
                            ->execute()
                            ->as_array();

        if (empty($recode_query))
        {
            \Session::set_flash('error', '記録が見つかりません。');
            \Response::redirect('dashboard');
        }

        $recode = $recode_query[0]; // 元のレコードデータを取得

        // POSTリクエストの場合（フォームが送信された場合）
        if (\Input::method() == 'POST')
        {
            // ここにバリデーションとデータベース更新のロジックを記述します
            $record_date = \Input::post('record_date');
            $weight = \Input::post('weight');

            // バリデーションオブジェクトを作成
            $val = \Validation::forge();
            $val->add('record_date', '記録日')->add_rule('required');
            $val->add('weight', '体重')
                ->add_rule('required')
                ->add_rule('numeric_min', 1)
                ->add_rule('numeric_max', 300)
                ->add_rule('match_pattern', '/^\d+(\.\d{1,2})?$/');

            if ($val->run())
            {
                // バリデーション成功
                $record_data = array(
                    'record_date' => $val->validated('record_date'),
                    'weight' => $val->validated('weight'),
                    'updated_at' => \Date::forge()->get_timestamp(),
                );

                // データベースを更新
                \DB::update('recodes')
                    ->set($record_data)
                    ->where('id', $id)
                    ->where('user_id', \Auth::get('id'))
                    ->execute();

                \Session::set_flash('success', '記録を更新しました！');
                \Response::redirect('dashboard');
            }
            else
            {
                // バリデーション失敗
                \Session::set_flash('error', $val->show_errors());

                // バリデーション失敗時もビューにデータを渡す
                $recode['record_date'] = \Input::post('record_date');
                $recode['weight'] = \Input::post('weight');
            }
        }

        // GETリクエストまたはPOSTリクエストでエラーがあった場合、フォームを再表示
        $data = array('recode' => $recode);
        return \View::forge('weight/edit', $data);
    }

    public function action_delete($id = null)
    {
        // レコードが存在するか確認
        $recode = \DB::select()
                    ->from('recodes')
                    ->where('id', $id)
                    ->where('user_id', \Auth::get('id'))
                    ->execute()
                    ->count();

        if ($recode > 0)
        {
            // レコードを削除
            \DB::delete('recodes')
                ->where('id', $id)
                ->where('user_id', \Auth::get('id'))
                ->execute();

            \Session::set_flash('success', '記録を削除しました。');
        }
        else
        {
            \Session::set_flash('error', '記録が見つかりません。');
        }

        // 削除後はダッシュボードへリダイレクト
        \Response::redirect('dashboard');
    }

    public function action_list()
    {
        // ログインユーザーのIDを取得
        $user_id = \Auth::get('id');

        // ユーザーのすべての記録を取得
        $recodes = \DB::select()
                    ->from('recodes')
                    ->where('user_id', $user_id)
                    ->order_by('record_date', 'desc')
                    ->execute()
                    ->as_array();

        // ビューにデータを渡す
        $data = array(
            'recodes' => $recodes,
        );

        // ビューを読み込む
        return \View::forge('weight/list', $data);
    }
}