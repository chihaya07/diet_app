<h1>ダッシュボード</h1>
<?php if (\Session::get_flash('success')): ?>
    <div style="color: green;">
        <?php echo \Session::get_flash('success'); ?>
    </div>
<?php endif; ?>

<p>こんにちは、<?php echo $username; ?> さん！</p>

<h2>体重推移</h2>
<div style="width: 80%; margin: auto;">
    <canvas id="weightChart"></canvas>
</div>
<h2>記録一覧</h2>
<?php if (empty($recodes)): ?>
    <p>記録がまだありません。</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>記録日</th>
                <th>体重 (kg)</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recodes as $recode): ?>
            <tr>
                <td><?php echo $recode['record_date']; ?></td>
                <td><?php echo $recode['weight']; ?></td>
                <td>
                    <a href="/weight/edit/<?php echo $recode['id']; ?>">編集</a> | 
                    <a href="/weight/delete/<?php echo $recode['id']; ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<h2>メニュー</h2>
<ul>
    <li><a href="/record">今日の記録</a></li>
    <li><a href="/target">目標設定</a> (未作成)</li>
    <li><a href="/weight/list">過去の記録一覧</a> (未作成)</li>
</ul>

<p><a href="/logout">ログアウト</a></p>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // グラフ描画のためのJavaScriptコード
    const recodes = <?php echo json_encode($recodes); ?>;
    const targetWeight = <?php echo json_encode($target_weight); ?>;

    // データがない場合は空の配列で初期化
    const labels = recodes.length > 0 ? recodes.map(recode => recode.record_date).reverse() : [];
    const weights = recodes.length > 0 ? recodes.map(recode => recode.weight).reverse() : [];
    const targets = recodes.length > 0 ? recodes.map(recode => targetWeight).reverse() : [];

    const data = {
        labels: labels,
        datasets: [
            {
                label: '体重',
                backgroundColor: 'rgb(0, 0, 255)',
                borderColor: 'rgb(0, 0, 255)',
                data: weights,
            },
            {
                label: '目標体重',
                backgroundColor: 'rgb(255, 0, 0)',
                borderColor: 'rgb(255, 0, 0)',
                data: targets,
                type: 'line'
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('weightChart'),
        config
    );
</script>