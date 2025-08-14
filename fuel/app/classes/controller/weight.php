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
            // バリデーションオブジェクトを作成
            $val = \Validation::forge();

            // ルールを追加
            $val->add('record_date', '記録日')
                ->add_rule('required');

            $val->add('weight', '体重')
                ->add_rule('required')
                ->add_rule('numeric_min', 1)
                ->add_rule('numeric_max', 300)
                ->add_rule('match_pattern', '/^\d+(\.\d{1,2})?$/');

            $val->add('meal_memo', '食事メモ');
            $val->add('work', '運動の有無');
            $val->add('work_memo', '運動メモ');


            // バリデーションを実行
            if ($val->run())
            {
                // バリデーション成功
                try
                {
                    // ログインユーザーのIDを取得
                    $user_id = \Auth::get('id');

                    // データベースに挿入するデータ
                    $record_data = array(
                        'user_id' => $user_id,
                        'record_date' => $val->validated('record_date'),
                        'weight' => $val->validated('weight'),
                        'meal_memo' => $val->validated('meal_memo'),
                        'work' => (\Input::post('work') === '1') ? 1 : 0, // チェックボックスの値
                        'work_memo' => $val->validated('work_memo'),
                        'created_at' => \Date::forge()->get_timestamp(),
                        'updated_at' => \Date::forge()->get_timestamp(),
                    );

                    // Modelを使ってDBに挿入
                    if (Model_Recode::create_recode($record_data))
                    {
                        \Session::set_flash('success', '記録を保存しました！');
                        \Response::redirect('dashboard'); // 記録後はダッシュボードへ
                    }
                    else
                    {
                        \Session::set_flash('error', '記録の保存に失敗しました。');
                    }
                }
                catch (\Exception $e)
                {
                    \Session::set_flash('error', '記録の保存に失敗しました：' . $e->getMessage());
                }
            }
            else
            {
                // バリデーション失敗
                \Session::set_flash('error', $val->show_errors());
            }
        }

        // GETリクエストまたはPOSTでエラーがあった場合
        return \View::forge('record/create');
    }

    public function action_edit($id = null)
    {
        $user_id = \Auth::get('id');
        $recode_query = Model_Recode::get_by_id_and_user_id($id, $user_id);

        if (empty($recode_query))
        {
            \Session::set_flash('error', '記録が見つかりません。');
            \Response::redirect('dashboard');
        }

        $recode = $recode_query[0];

        if (\Input::method() == 'POST')
        {
            $record_date = \Input::post('record_date');
            $weight = \Input::post('weight');

            $val = \Validation::forge();
            $val->add('record_date', '記録日')->add_rule('required');
            $val->add('weight', '体重')
                ->add_rule('required')
                ->add_rule('numeric_min', 1)
                ->add_rule('numeric_max', 300)
                ->add_rule('match_pattern', '/^\d+(\.\d{1,2})?$/');

            if ($val->run())
            {
                $record_data = array(
                    'record_date' => $val->validated('record_date'),
                    'weight' => $val->validated('weight'),
                    'updated_at' => \Date::forge()->get_timestamp(),
                );

                if (Model_Recode::update_recode($id, $user_id, $record_data))
                {
                    \Session::set_flash('success', '記録を更新しました！');
                    \Response::redirect('dashboard');
                }
                else
                {
                    \Session::set_flash('error', '記録の更新に失敗しました。');
                }
            }
            else
            {
                \Session::set_flash('error', $val->show_errors());

                $recode['record_date'] = \Input::post('record_date');
                $recode['weight'] = \Input::post('weight');
            }
        }
        $data = array('recode' => $recode);
        return \View::forge('weight/edit', $data);
    }

    public function action_delete($id = null)
    {
        $user_id = \Auth::get('id');
        $recode_exists = Model_Recode::get_by_id_and_user_id($id, $user_id);

        if (!empty($recode_exists))
        {
            if (Model_Recode::delete_recode($id, $user_id))
            {
                \Session::set_flash('success', '記録を削除しました。');
            }
            else
            {
                \Session::set_flash('error', '記録の削除に失敗しました。');
            }
        }
        else
        {
            \Session::set_flash('error', '記録が見つかりません。');
        }
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