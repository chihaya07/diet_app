<style>
    body { font-family: sans-serif; margin: 0; padding: 0; }
    .container { max-width: 960px; margin: 0 auto; padding: 20px; }
    .dashboard-header { background-color: #e0f2ff; padding: 20px; text-align: center; position: relative; }
    .dashboard-header h1 { margin: 0; }
    .dashboard-header .menu-icon { position: absolute; top: 20px; right: 20px; font-size: 24px; cursor: pointer; }
    .chart-section { margin-top: 20px; }
    .chart-section .chart-title { font-size: 1.2em; font-weight: bold; }
    .chart-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .controls { display: flex; justify-content: flex-start; margin-top: 20px; position: relative; }
    .controls .add-btn, .controls .sort-btn, .controls .target-btn { padding: 10px 20px; margin-right: 10px; border: 1px solid #ccc; background-color: #f0f0f0; border-radius: 4px; cursor: pointer; }
    .record-list { margin-top: 20px; }
    .record-item { display: flex; align-items: center; justify-content: space-between; padding: 10px; border: 1px solid #ccc; margin-bottom: 10px; border-radius: 4px; }
    .record-item-info { flex-grow: 1; }
    .record-item-actions button { border: none; background-color: transparent; cursor: pointer; }
    .target-section { background-color: #e0f2ff; padding: 10px; border-radius: 8px; text-align: center; margin-top: 20px; }
    .sort-popup { position: absolute; top: 100%; left: 140px; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 10px; z-index: 10; display: none; }
    .sort-popup a { display: block; padding: 5px; text-decoration: none; color: black; }
    .sort-popup a:hover { background-color: #f0f0f0; }
</style>

<div class="dashboard-header">
    <h1>ダッシュボード</h1>
    
    <div class="chart-section">
        <div class="chart-title">体重推移</div>
        <div class="chart-container">
            <canvas id="weightChart"></canvas>
        </div>
    </div>
</div>

<div class="container">
    <?php if (\Session::get_flash('success')): ?>
        <div style="color: green;">
            <?php echo \Session::get_flash('success'); ?>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const recodes = <?php echo json_encode($recodes); ?>;
        const targetWeight = <?php echo json_encode($target_weight); ?>;

        const labels = recodes.map(recode => recode.record_date);
        const weights = recodes.map(recode => recode.weight);
        const targets = recodes.map(recode => targetWeight);

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

    <div class="controls">
        <button class="add-btn" onclick="location.href='/record'">＋ 追加</button>
        <button class="sort-btn" data-bind="click: toggleSortPopup">並び替え</button>
        <div class="sort-popup" data-bind="style: { display: isSortPopupVisible() ? 'block' : 'none' }">
            <a href="#" data-bind="click: sortByRecordDate">記録日 (<span data-bind="text: sortOrderText"></span>)</a>
            <a href="#" data-bind="click: sortByWeight">体重 (昇順/降順)</a>
        </div>
        <button class="target-btn" onclick="location.href='/target'">目標設定</button>
        <button class="recods-btn" onclick="location.href='/react'">運動と食事記録</button>
    </div>

    <div class="record-list" data-bind="foreach: sortedRecords">
        <div class="record-item">
            <div class="record-item-info">
                日付: <span data-bind="text: record_date"></span>日&emsp;体重: <span data-bind="text: weight"></span> kg&emsp;運動: <span data-bind="text: work == 1 ? 'あり' : 'なし'"></span>
            </div>
            <div class="record-item-actions">
                <a data-bind="attr: { href: '/weight/edit/' + id }"><button>&#9998;</button></a>
                <a data-bind="attr: { href: '/weight/delete/' + id }" onclick="return confirm('本当に削除しますか？');"><button>🗑️</button></a>
            </div>
        </div>
    </div>

    <div class="target-section">
        <p>
            <?php 
                if (!empty($monthly_at)) {
                    $month = explode('-', $monthly_at)[1];
                    echo "{$month}月の運動回数目標です";
                } else {
                    echo "目標が設定されていません";
                }
            ?>
        </p>
        <p><?php echo $work_count; ?>/<?php echo $target_work; ?> 達成</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>

<script type="text/javascript">
function DashboardViewModel(initialRecords) {
    var self = this;
    self.records = ko.observableArray(initialRecords);
    self.isSortPopupVisible = ko.observable(false);
    self.sortField = ko.observable('record_date');
    self.sortOrder = ko.observable('desc');

    self.sortedRecords = ko.computed(function() {
        var field = self.sortField();
        var order = self.sortOrder();

        var sorted = self.records().slice().sort(function(a, b) { // .slice()でコピーを作成
            var aVal = a[field];
            var bVal = b[field];

            if (field === 'record_date') {
                aVal = new Date(aVal);
                bVal = new Date(bVal);
            }

            if (aVal < bVal) {
                return order === 'asc' ? -1 : 1;
            } else if (aVal > bVal) {
                return order === 'asc' ? 1 : -1;
            }
            return 0;
        });
        return sorted;
    });

    self.toggleSortPopup = function() {
        self.isSortPopupVisible(!self.isSortPopupVisible());
    };

    self.sortByRecordDate = function() {
        if (self.sortField() === 'record_date') {
            self.sortOrder(self.sortOrder() === 'asc' ? 'desc' : 'asc');
        } else {
            self.sortField('record_date');
            self.sortOrder('desc');
        }
        self.isSortPopupVisible(false);
    };

    self.sortByWeight = function() {
        if (self.sortField() === 'weight') {
            self.sortOrder(self.sortOrder() === 'asc' ? 'desc' : 'asc');
        } else {
            self.sortField('weight');
            self.sortOrder('asc');
        }
        self.isSortPopupVisible(false);
    };

    self.sortOrderText = ko.computed(function() {
        if (self.sortField() === 'record_date') {
            return self.sortOrder() === 'asc' ? '古い順' : '新しい順';
        }
        if (self.sortField() === 'weight') {
            return self.sortOrder() === 'asc' ? '軽い順' : '重い順';
        }
        return '';
    });
}


var initialRecords = <?php echo json_encode($recodes); ?>;
ko.applyBindings(new DashboardViewModel(initialRecords));
</script>