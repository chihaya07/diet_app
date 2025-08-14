<?php

class Controller_Dashboard extends Controller
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
        $user_id = \Auth::get('id');
        $username = \Auth::get('username');
        $email = \Auth::get('email');

        // ユーザーの記録を取得
        $recodes = Model_Recode::get_all_by_user_id($user_id);

        // 目標体重と目標運動回数を取得
        $target_query = \DB::select('target_weight', 'target_work', 'monthly_at')
                                ->from('targets')
                                ->where('user_id', $user_id)
                                ->order_by('monthly_at', 'desc')
                                ->limit(1)
                                ->execute()
                                ->as_array();

        $target_weight = isset($target_query[0]['target_weight']) ? $target_query[0]['target_weight'] : 0;
        $target_work = isset($target_query[0]['target_work']) ? $target_query[0]['target_work'] : 0;
        $monthly_at = isset($target_query[0]['monthly_at']) ? $target_query[0]['monthly_at'] : null;

        // 今月の運動回数を取得
        $current_month = date('Y-m');
        $current_work_count = \DB::select(\DB::expr('COUNT(*) AS work_count'))
                                 ->from('recodes')
                                 ->where('user_id', $user_id)
                                 ->where('record_date', 'LIKE', $current_month . '-%')
                                 ->where('work', 1)
                                 ->execute()
                                 ->as_array();
        $work_count = $current_work_count[0]['work_count'];

        $data = array(
            'username' => $username,
            'email' => $email,
            'user_id' => $user_id,
            'recodes' => $recodes,
            'target_weight' => $target_weight,
            'target_work' => $target_work,
            'work_count' => $work_count,
            'monthly_at' => $monthly_at,
        );

        return \View::forge('dashboard/index', $data);
    }
}