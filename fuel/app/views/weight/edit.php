<h1>体重記録 - 編集</h1>

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

<form action="/weight/edit/<?php echo $recode['id']; ?>" method="post">
    <label for="record_date">記録日:</label><br>
    <input type="date" id="record_date" name="record_date" value="<?php echo $recode['record_date']; ?>"><br>
    <label for="weight">体重 (kg):</label><br>
    <input type="number" id="weight" name="weight" step="0.01" value="<?php echo $recode['weight']; ?>"><br><br>
    <button type="submit">更新する</button>
</form>

<p><a href="/dashboard">ダッシュボードに戻る</a></p>