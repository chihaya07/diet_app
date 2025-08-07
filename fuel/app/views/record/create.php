<h1>今日の記録</h1>

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

<form action="/record" method="post">
    <label for="record_date">記録日:</label><br>
    <input type="date" id="record_date" name="record_date" value="<?php echo \Input::post('record_date', date('Y-m-d')); ?>"><br><br>

    <label for="weight">体重 (kg):</label><br>
    <input type="number" id="weight" name="weight" step="0.01" value="<?php echo \Input::post('weight'); ?>"><br><br>

    <label for="meal_memo">食事メモ:</label><br>
    <textarea id="meal_memo" name="meal_memo" rows="4" cols="50"><?php echo \Input::post('meal_memo'); ?></textarea><br><br>

    <label for="work">運動しましたか？</label>
    <input type="checkbox" id="work" name="work" value="1" <?php echo (\Input::post('work') === '1') ? 'checked' : ''; ?>><br><br>
    <label for="work_memo">運動メモ:</label><br>
    <textarea id="work_memo" name="work_memo" rows="4" cols="50"><?php echo \Input::post('work_memo'); ?></textarea><br><br>

    <button type="submit">記録する</button>
</form>

<p><a href="/dashboard">ダッシュボードに戻る</a></p>