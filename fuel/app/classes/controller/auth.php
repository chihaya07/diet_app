<?php
class Controller_Auth extends Controller
{
    public function action_register()
    {
        // 登録フォームを表示するロジック
        return \View::forge('auth/register');
    }
}