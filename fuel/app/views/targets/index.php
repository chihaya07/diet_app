<style>
    body { font-family: sans-serif; margin: 0; padding: 0; background-color: #e0f2ff; }
    .target-form-container { max-width: 400px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { text-align: center; }
    .form-group { margin-bottom: 15px; }
    label { font-weight: bold; }
    input[type="month"], input[type="number"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
    button[type="submit"] { width: 100%; padding: 10px; border: none; background-color: #ff5757; color: white; font-size: 1.2em; border-radius: 4px; cursor: pointer; }
    .back-link { display: block; text-align: center; margin-top: 20px; }
</style>

<div class="target-form-container">
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
        <div class="form-group">
            <label for="monthly_at">目標月:</label>
            <input type="month" id="monthly_at" name="monthly_at" value="<?php echo isset($target['monthly_at']) ? $target['monthly_at'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="target_weight">目標体重 (kg):</label>
            <input type="number" id="target_weight" name="target_weight" step="0.01" value="<?php echo isset($target['target_weight']) ? $target['target_weight'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="target_work">目標運動回数 (回/月):</label>
            <input type="number" id="target_work" name="target_work" value="<?php echo isset($target['target_work']) ? $target['target_work'] : ''; ?>" required>
        </div>
        <?php echo \Form::csrf(); ?>
        <button type="submit">目標を設定</button>
    </form>

    <a href="/dashboard" class="back-link">ダッシュボードに戻る</a>
</div>