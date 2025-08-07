<?php

class Controller_Targets extends Controller
{
    public function before()
    {
        if (! \Auth::check())
        {
            \Response::redirect('login');
        }
    }

    public function action_index()
    {
        $data = array();

        // POSTリクエストの場合（フォームが送信された場合）
        if (\Input::method() == 'POST')
        {
            // バリデーションオブジェクトを作成
            $val = \Validation::forge();

            // ルールを追加
            $val->add('target_weight', '目標体重')
                ->add_rule('required')
                ->add_rule('numeric_min', 1)
                ->add_rule('numeric_max', 300)
                ->add_rule('match_pattern', '/^\d+(\.\d{1,2})?$/');

            $val->add('monthly_at', '目標月')
                ->add_rule('required');

            $val->add('target_work', '目標運動回数')
                ->add_rule('required')
                ->add_rule('numeric_min', 0)
                ->add_rule('numeric_max', 31);

            // バリデーションを実行
            if ($val->run())
            {
                try
                {
                    $user_id = \Auth::get('id');

                    // 既に目標が設定されているか確認
                    $target_exists = \DB::select()
                                        ->from('targets')
                                        ->where('user_id', $user_id)
                                        ->where('monthly_at', $val->validated('monthly_at'))
                                        ->execute()
                                        ->count();

                    $target_data = array(
                        'user_id' => $user_id,
                        'target_weight' => $val->validated('target_weight'),
                        'target_work' => $val->validated('target_work'),
                        'monthly_at' => $val->validated('monthly_at'),
                        'updated_at' => \Date::forge()->get_timestamp(),
                    );

                    if ($target_exists > 0)
                    {
                        // 既存の目標を更新
                        \DB::update('targets')
                            ->set($target_data)
                            ->where('user_id', $user_id)
                            ->where('monthly_at', $val->validated('monthly_at'))
                            ->execute();
                        \Session::set_flash('success', '目標を更新しました！');
                    }
                    else
                    {
                        // 新しい目標を挿入
                        $target_data['created_at'] = \Date::forge()->get_timestamp();
                        \DB::insert('targets')
                            ->set($target_data)
                            ->execute();
                        \Session::set_flash('success', '新しい目標を設定しました！');
                    }

                    \Response::redirect('dashboard');
                }
                catch (\Exception $e)
                {
                    \Session::set_flash('error', '目標設定に失敗しました：' . $e->getMessage());
                }
            }
            else
            {
                // バリデーション失敗
                \Session::set_flash('error', $val->show_errors());
            }
        }

        // GETリクエストまたはPOSTでエラーがあった場合
        return \View::forge('targets/index');
    }
}