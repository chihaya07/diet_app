<?php
return array(
    '_root_'  => 'welcome/index',  // The default route
    '_404_'   => 'welcome/404',    // The 404 route

    // 新しく追加するルート
    'register' => 'auth/register', // /register へのアクセスで Authコントローラーの register アクションを呼び出す
    'login'    => 'auth/login',
    'dashboard' => 'dashboard',
    'logout' => 'auth/logout',
);
