<h1>体重記録 - 全ての一覧</h1>

<p><a href="/dashboard">ダッシュボードに戻る</a></p>

<div>
    <label for="filterDate">日付範囲で絞り込み:</label>
    <input type="date" id="filterDateStart" data-bind="value: filterDateStart">
    〜
    <input type="date" id="filterDateEnd" data-bind="value: filterDateEnd">
    <button data-bind="click: filterRecords">絞り込み</button>
</div>
<br>

<div>
    並び替え:
    <a href="#" data-bind="click: sortByDate">記録日</a> |
    <a href="#" data-bind="click: sortByWeight">体重</a>
</div>
<br>

<table border="1">
    <thead>
        <tr>
            <th>記録日</th>
            <th>体重 (kg)</th>
            <th></th>
        </tr>
    </thead>
    <tbody data-bind="foreach: filteredRecords">
        <tr>
            <td data-bind="text: record_date"></td>
            <td data-bind="text: weight"></td>
            <td>
                <a data-bind="attr: { href: '/weight/edit/' + id }">編集</a>
                |
                <a data-bind="attr: { href: '/weight/delete/' + id }" onclick="return confirm('本当に削除しますか？');">削除</a>
            </td>
        </tr>
    </tbody>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.js"></script>

<script type="text/javascript">
function RecordsViewModel(records) {
    var self = this;
    self.records = ko.observableArray(records);
    self.filterDateStart = ko.observable('');
    self.filterDateEnd = ko.observable('');
    self.sortAscending = ko.observable(false);

    self.filteredRecords = ko.computed(function() {
        var filterStart = self.filterDateStart();
        var filterEnd = self.filterDateEnd();
        var sortAsc = self.sortAscending();

        // フィルタリング
        var filtered = self.records().filter(function(record) {
            var recordDate = new Date(record.record_date);
            var startDate = filterStart ? new Date(filterStart) : null;
            var endDate = filterEnd ? new Date(filterEnd) : null;
            return (!startDate || recordDate >= startDate) && (!endDate || recordDate <= endDate);
        });

        // ソート
        return filtered.sort(function(a, b) {
            var sort = (a.record_date < b.record_date) ? -1 : 1;
            return sortAsc ? sort : -sort;
        });
    });

    self.filterRecords = function() {
        // フィルタリングロジックはcomputedが自動で行う
    };

    self.sortByDate = function() {
        self.sortAscending(!self.sortAscending());
    };

    self.sortByWeight = function() {
        var sorted = self.records().sort(function(a, b) {
            var sort = (a.weight < b.weight) ? -1 : 1;
            return self.sortAscending() ? sort : -sort;
        });
        self.records(sorted);
        self.sortAscending(!self.sortAscending());
    };
}

var initialRecords = <?php echo json_encode($recodes); ?>;
ko.applyBindings(new RecordsViewModel(initialRecords));
</script>