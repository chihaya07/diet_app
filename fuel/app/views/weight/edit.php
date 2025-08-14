<style>
    body { font-family: sans-serif; margin: 0; padding: 0; background-color: #e0f2ff; }
    .record-form-container { max-width: 400px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { text-align: center; }
    .form-group { margin-bottom: 15px; }
    label { font-weight: bold; }
    input[type="date"], input[type="number"], textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
    .radio-group { display: flex; align-items: center; }
    .radio-group input[type="radio"] { margin-right: 5px; }
    .radio-group label { margin-right: 20px; font-weight: normal; }
    button[type="submit"] { width: 100%; padding: 10px; border: none; background-color: #ff5757; color: white; font-size: 1.2em; border-radius: 4px; cursor: pointer; }
    .back-link { display: block; text-align: center; margin-top: 20px; }
</style>

<div class="record-form-container">
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
        <div class="form-group">
            <label for="record_date">記録日:</label><br>
            <input type="date" id="record_date" name="record_date" value="<?php echo $recode['record_date']; ?>"><br>
        </div>

        <div class="form-group">
            <label for="weight">体重 (kg):</label><br>
            <input type="number" id="weight" name="weight" step="0.01" value="<?php echo $recode['weight']; ?>"><br><br>
        </div>

        <?php echo \Form::csrf(); ?>
        <button type="submit">更新する</button>
    </form>

    <a href="/dashboard" class="back-link">ダッシュボードに戻る</a>
</div>