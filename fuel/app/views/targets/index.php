<h1>目標設定</h1>

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

<form action="/targets" method="post">
    <label for="monthly_at">目標月:</label><br>
    <input type="month" id="monthly_at" name="monthly_at" required><br>

    <label for="target_weight">目標体重 (kg):</label><br>
    <input type="number" id="target_weight" name="target_weight" step="0.01" required><br>

    <label for="target_work">目標運動回数 (回/月):</label><br>
    <input type="number" id="target_work" name="target_work" required><br><br>

    <button type="submit">目標を設定する</button>
</form>

<p><a href="/dashboard">ダッシュボードに戻る</a></p>