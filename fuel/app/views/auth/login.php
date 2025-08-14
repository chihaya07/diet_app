<style>
    body { font-family: sans-serif; margin: 0; padding: 0; background-color: #e0f2ff; }
    .auth-form-container { max-width: 400px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { text-align: center; }
    .form-group { margin-bottom: 15px; }
    label { font-weight: bold; }
    input[type="email"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
    .checkbox-group { display: flex; align-items: center; margin-top: 10px; }
    .checkbox-group input { margin-right: 5px; }
    button[type="submit"] { width: 100%; padding: 10px; border: none; background-color: #ff5757; color: white; font-size: 1.2em; border-radius: 4px; cursor: pointer; }
    .back-link { display: block; text-align: center; margin-top: 20px; }
</style>

<div class="auth-form-container">
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
        <div class="form-group">
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" value="<?php echo \Input::post('email'); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="remember_me" name="remember_me" value="1">
            <label for="remember_me">次回から自動ログイン</label>
        </div><br>
        <?php echo \Form::csrf(); ?>
        <button type="submit">ログイン</button>
    </form>

    <a href="/register" class="back-link">アカウントをお持ちでない方はこちらから新規登録</a>
</div>