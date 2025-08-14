<?php
return array(
    '_root_'  => 'welcome/index',  // The default route
    '_404_'   => 'welcome/404',    // The 404 route

    // 新しく追加するルート
    'register' => 'auth/register', // /register へのアクセスで Authコントローラーの register アクションを呼び出す
    'login'    => 'auth/login',
    'dashboard' => 'dashboard',
    'logout' => 'auth/logout',

    'record' => 'record/create',
    'weight/edit/(:num)' => 'weight/edit/$1',   // 編集ページ
    'weight/delete/(:num)' => 'weight/delete/$1', // 削除処理
    'target' => 'targets/index', //目標設定ページ

    'react' => 'welcome/react_page',
    'api/recodes' => 'api/recodes', // 記録のデータを取得するAPIエンドポイント
);
