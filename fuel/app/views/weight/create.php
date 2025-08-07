<h1>体重記録 - 新規作成</h1>

<form action="/weight/create" method="post">
    <label for="record_date">記録日:</label><br>
    <input type="date" id="record_date" name="record_date" value="<?php echo \Input::post('record_date'); ?>"><br>
    <label for="weight">体重 (kg):</label><br>
    <input type="number" id="weight" name="weight" step="0.01" value="<?php echo \Input::post('weight'); ?>"><br><br>
    <button type="submit">記録する</button>
</form>

<p><a href="/dashboard">ダッシュボードに戻る</a></p>