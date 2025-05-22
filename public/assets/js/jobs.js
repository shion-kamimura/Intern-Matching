document.addEventListener('DOMContentLoaded', () => {
    const JobViewModel = function() {
        const self = this;
        self.jobs = ko.observableArray([]);
        self.sortKey = ko.observable('created_at');

        self.loadJobs = function(sort = 'created_at') {
            fetch(`/api/jobs/list?sort=${sort}`)
                .then(response => response.json())
                .then(data => {
                    self.jobs(data); // バインディングされる jobs に代入
                });
        };

        self.sortJobs = function(key) {
            self.sortKey(key);
            self.loadJobs(key);
        };
    };

    // グローバル変数にしてHTMLのonclickから使えるようにする
    window.viewModel = new JobViewModel();
    ko.applyBindings(window.viewModel);
    window.viewModel.loadJobs(); // 初回読み込み
});