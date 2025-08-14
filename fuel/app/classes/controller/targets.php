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
        $user_id = \Auth::get('id');

        // POSTリクエストの場合（フォームが送信された場合）
        if (\Input::method() == 'POST')
        {
            // バリデーションオブジェクトを作成
            $val = \Validation::forge();
            $val->add('target_weight', '目標体重')
                ->add_rule('required')
                ->add_rule('numeric_min', 1)
                ->add_rule('numeric_max', 300)
                ->add_rule('match_pattern', '/^\d+(\.\d{1,2})?$/');

            $val->add('monthly_at', '目標月')
                ->add_rule('required')
                ->add_rule('match_pattern', '/^\d{4}-\d{2}$/'); // YYYY-MM 形式をチェック

            $val->add('target_work', '目標運動回数')
                ->add_rule('required')
                ->add_rule('numeric_min', 0)
                ->add_rule('numeric_max', 31)
                ->add_rule('valid_string', array('numeric')); // 数値であることをチェック

            if ($val->run())
            {
                try
                {
                    $monthly_at = $val->validated('monthly_at');
                    $target_weight = $val->validated('target_weight');
                    $target_work = $val->validated('target_work');

                    // データベースに挿入または更新するデータ
                    $target_data = array(
                        'user_id' => $user_id,
                        'target_weight' => $target_weight,
                        'target_work' => $target_work,
                        'monthly_at' => $monthly_at,
                        'updated_at' => \Date::forge()->get_timestamp(),
                    );

                    // 同じ月にすでに目標が設定されているか確認
                    $target_exists = \DB::select()
                                        ->from('targets')
                                        ->where('user_id', $user_id)
                                        ->where('monthly_at', $monthly_at)
                                        ->execute()
                                        ->count();

                    if ($target_exists > 0)
                    {
                        // 既存の目標を更新
                        \DB::update('targets')
                            ->set($target_data)
                            ->where('user_id', $user_id)
                            ->where('monthly_at', $monthly_at)
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
        // 既存の目標データを取得してフォームに表示
        $current_target = \DB::select()
                            ->from('targets')
                            ->where('user_id', $user_id)
                            ->order_by('monthly_at', 'desc')
                            ->limit(1)
                            ->execute()
                            ->as_array();

        $data['target'] = isset($current_target[0]) ? $current_target[0] : null;

        return \View::forge('targets/index', $data);
    }
}