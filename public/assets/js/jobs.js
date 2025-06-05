document.addEventListener('DOMContentLoaded', () => {
    // Knockout.js の ViewModel（求人一覧とソートを管理）
    const JobViewModel = function() {
        const self = this;

        // 求人一覧（observableArray にすると UI が自動更新される）
        self.jobs = ko.observableArray([]);

        // 現在のソートキー（'created_at' or 'likes'）
        self.sortKey = ko.observable('created_at');

        // ローディング中かどうか（ボタン制御等に使える）
        self.isLoading = ko.observable(false);

        // APIから求人情報を読み込む
        self.loadJobs = function(sort = 'created_at') {
            self.isLoading(true); // 読み込み中フラグON

            fetch(`/api/jobs/list?sort=${sort}`)
                .then(response => {
                    if (!response.ok) throw new Error('ネットワークエラー');
                    return response.json();
                })
                .then(data => {
                    self.jobs(data); // データを更新（UIに反映）
                })
                .catch(error => {
                    console.error('求人の取得に失敗しました:', error);
                    alert('求人情報の取得に失敗しました。');
                })
                .finally(() => {
                    self.isLoading(false); // ローディング終了
                });
        };

        // ソートの変更処理
        self.sortJobs = function(key) {
            const allowed = ['created_at', 'likes'];
            if (!allowed.includes(key)) {
                console.warn('許可されていないソートキー:', key);
                return;
            }

            self.sortKey(key);      // ソートキー更新
            self.loadJobs(key);     // 再読み込み
        };
    };

    // ViewModel をインスタンス化し、グローバルにセット
    window.viewModel = new JobViewModel();

    // Knockout.js のバインディングを適用
    ko.applyBindings(window.viewModel);

    // ページ読み込み時に初期データを取得
    window.viewModel.loadJobs();
});
