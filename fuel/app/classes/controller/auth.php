<?php
class Controller_Auth extends Controller
{
    public function action_register()
    {
        $data = array(); // ビューに渡すデータを初期化

        // POSTリクエストの場合（フォームが送信された場合）
        if (\Input::method() == 'POST')
        {
            // バリデーションオブジェクトを作成
            $val = \Validation::forge();

            // ユーザー名のルール
            $val->add('username', 'ユーザー名')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 50);

            // メールアドレスのルール
            $val->add('email', 'メールアドレス')
                ->add_rule('required')
                ->add_rule('valid_email')
                ->add_rule('min_length', 5)
                ->add_rule('max_length', 255);

            // パスワードのルール
            $val->add('password', 'パスワード')
                ->add_rule('required')
                ->add_rule('min_length', 6) // 最低6文字
                ->add_rule('max_length', 255);

            // バリデーションを実行
            if ($val->run())
            {
                // バリデーション成功
                $username = $val->validated('username');
                $email = $val->validated('email');
                $password = $val->validated('password');

                try
                {
                    // メールアドレスの重複チェック (Authドライバの直接メソッドが使えないため、DBを直接クエリ)
                    $user_exists = \DB::select()
                                        ->from('users')
                                        ->where('email', $email)
                                        ->execute()
                                        ->count();

                    if ($user_exists > 0) // ユーザーが既に存在する場合
                    {
                        \Session::set_flash('error', 'このメールアドレスは既に登録されています。');
                    }
                    else
                    {
                        // ユーザーを登録
                        // Auth::create_user はパスワードを自動的にハッシュ化します
                        $user_id = \Auth::create_user(
                            $email,     // Authのデフォルトではemailをユーザー名（ログインID）として扱う
                            $password,  // パスワード
                            $email,     // Eメールアドレス
                            1,          // グループID (例: 1=一般ユーザー)
                            array('username' => $username) // 追加のプロフィールフィールドとしてユーザー名を渡す
                        );

                        if ($user_id)
                        {
                            \Session::set_flash('success', 'ユーザー登録が完了しました！');
                            \Response::redirect('login'); // ログインページへリダイレクト
                        }
                        else
                        {
                            \Session::set_flash('error', 'ユーザー登録に失敗しました。');
                        }
                    }
                }
                catch (\SimpleUserUpdateException $e)
                {
                    \Session::set_flash('error', $e->getMessage());
                }
            }
            else
            {
                // バリデーション失敗
                \Session::set_flash('error', $val->show_errors());
            }
        }

        // GETリクエストまたはPOSTリクエストでエラーがあった場合、フォームを再表示
        return \View::forge('auth/register', $data);
    }
        public function action_login() // ★ このメソッドを追加
    {
        $data = array(); // ビューに渡すデータを初期化

        // POSTリクエストの場合（ログインフォームが送信された場合）
        if (\Input::method() == 'POST')
        {
            $email = \Input::post('email');
            $password = \Input::post('password');
            $remember_me = (bool) \Input::post('remember_me'); // 「次回から自動ログイン」オプションがあれば

            // Auth::login() でログインを試みる
            if (\Auth::login($email, $password, $remember_me))
            {
                \Session::set_flash('success', 'ログインしました！');
                \Response::redirect('dashboard'); // ログイン成功後はダッシュボードへリダイレクト（後で作成）
            }
            else
            {
                \Session::set_flash('error', 'メールアドレスまたはパスワードが間違っています。');
            }
        }
        // GETリクエストまたはPOSTリクエストでエラーがあった場合、フォームを再表示
        return \View::forge('auth/login', $data);
    }

        public function action_logout() // ★ このメソッドを追加
    {
        \Auth::logout();
        \Session::set_flash('success', 'ログアウトしました。');
        \Response::redirect('login'); // ログアウト後はログインページへ
    }
}