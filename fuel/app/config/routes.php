<?php
return array(
    '_root_'  => 'welcome/index',  // The default route
    '_404_'   => 'welcome/404',    // The 404 route

    // 'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'), // これは残しても削除してもOK

    // 新しく追加するルート
    'register' => 'auth/register', // /register へのアクセスで Authコントローラーの register アクションを呼び出す
);
