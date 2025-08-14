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
    <h1>記録フォーム</h1>

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
        <div class="form-group">
            <label for="record_date">記録日:</label>
            <input type="date" id="record_date" name="record_date" value="<?php echo \Input::post('record_date', date('Y-m-d')); ?>">
        </div>

        <div class="form-group">
            <label for="weight">体重:</label>
            <input type="number" id="weight" name="weight" step="0.01" value="<?php echo \Input::post('weight'); ?>">
        </div>

        <div class="form-group">
            <label>運動:</label>
            <div class="radio-group">
                <input type="radio" id="work_yes" name="work" value="1" <?php echo (\Input::post('work') === '1') ? 'checked' : ''; ?>>
                <label for="work_yes">あり</label>
                <input type="radio" id="work_no" name="work" value="0" <?php echo (\Input::post('work') === '0' || \Input::post('work') === null) ? 'checked' : ''; ?>>
                <label for="work_no">なし</label>
            </div>
        </div>

        <div class="form-group">
            <label for="work_memo">運動内容:</label>
            <textarea id="work_memo" name="work_memo" rows="4" cols="50"><?php echo \Input::post('work_memo'); ?></textarea>
        </div>

        <div class="form-group">
            <label for="meal_memo">食事内容:</label>
            <textarea id="meal_memo" name="meal_memo" rows="4" cols="50"><?php echo \Input::post('meal_memo'); ?></textarea>
        </div>
        <?php echo \Form::csrf(); ?>
        <button type="submit">記録</button>
    </form>

    <a href="/dashboard" class="back-link">ダッシュボードに戻る</a>
</div>