<?php

class Controller_Record extends Controller
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
        if (\Input::method() === 'POST')
        {
            // バリデーションオブジェクトを作成
            $val = \Validation::forge();

            // ルールを追加
            $val->add('record_date', '記録日')
                ->add_rule('required');

            $val->add('weight', '体重')
                ->add_rule('required') // 必須
                ->add_rule('numeric_min', 1) // 1以上
                ->add_rule('numeric_max', 300) // 300以下
                ->add_rule('match_pattern', '/^\d+(\.\d{1,2})?$/'); // ★小数点以下2桁までの数値形式

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

                    // DBへの挿入
                    \DB::insert('recodes')
                        ->set($record_data)
                        ->execute();

                    \Session::set_flash('success', '記録を保存しました！');
                    \Response::redirect('dashboard'); // 記録後はダッシュボードへ
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
}