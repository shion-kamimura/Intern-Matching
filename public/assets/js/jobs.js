document.addEventListener('DOMContentLoaded', () => {
    const JobViewModel = function() {
        const self = this;
        self.jobs = ko.observableArray([]);
        self.sortKey = ko.observable('created_at');
        self.isLoading = ko.observable(false);

        self.loadJobs = function(sort = 'created_at') {
            self.isLoading(true);
            fetch(`/api/jobs/list?sort=${sort}`)
                .then(response => {
                    if (!response.ok) throw new Error('ネットワークエラー');
                    return response.json();
                })
                .then(data => {
                    self.jobs(data);
                })
                .catch(error => {
                    console.error('求人の取得に失敗しました:', error);
                    alert('求人情報の取得に失敗しました。');
                })
                .finally(() => {
                    self.isLoading(false);
                });
        };

        self.sortJobs = function(key) {
            const allowed = ['created_at', 'likes'];
            if (!allowed.includes(key)) {
                console.warn('許可されていないソートキー:', key);
                return;
            }
            self.sortKey(key);
            self.loadJobs(key);
        };
    };

    window.viewModel = new JobViewModel();
    ko.applyBindings(window.viewModel);
    window.viewModel.loadJobs();
});
