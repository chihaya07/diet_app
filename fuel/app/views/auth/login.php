<h1>ログイン</h1>

<?php if (\Session::get_flash('success')): ?>
    <div style="color: green;">
        <?php echo \Session::get_flash('success'); ?>
    </div>
<?php endif; ?>

<?php if (\Session::get_flash('error')): ?>
    <div style="color: red;">
        <?php echo \Session::get_flash('error'); ?>
    </div>
<?php endif; ?>

<form action="/login" method="post">
    <label for="email">メールアドレス:</label><br>
    <input type="email" id="email" name="email" value="<?php echo \Input::post('email'); ?>"><br>
    <label for="password">パスワード:</label><br>
    <input type="password" id="password" name="password"><br>
    <input type="checkbox" id="remember_me" name="remember_me" value="1">
    <label for="remember_me">次回から自動ログイン</label><br><br>
    <button type="submit">ログイン</button>
</form>
<p>アカウントをお持ちでない方は <a href="/register">こちら</a> から新規登録してください。</p>