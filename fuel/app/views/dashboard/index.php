<h1>ダッシュボード</h1>
<?php if (\Session::get_flash('success')): ?>
    <div style="color: green;">
        <?php echo \Session::get_flash('success'); ?>
    </div>
<?php endif; ?>

<p>こんにちは、<?php echo $username; ?> さん！</p>
<p>あなたのメールアドレス: <?php echo $email; ?></p>
<p>あなたのユーザーID: <?php echo $user_id; ?></p>

<h2>メニュー</h2>
<ul>
    <li><a href="/record">今日の記録</a> (未作成)</li>
    <li><a href="/target">目標設定</a> (未作成)</li>
    <li><a href="/recode_list">過去の記録一覧</a> (未作成)</li>
</ul>

<p><a href="/logout">ログアウト</a></p>