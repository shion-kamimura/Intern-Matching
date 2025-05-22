<?= View::forge('header'); ?>

<main>
    <div class="container mt-5 mb-5 pt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">募集一覧</h1>
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    フィルター
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="viewModel.sortJobs('created_at')">新着順</a></li>
                    <li><a class="dropdown-item" href="#" onclick="viewModel.sortJobs('likes')">いいね数が多い順</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div data-bind="foreach: jobs">
        <div class="container mb-5">
            <div class="card">
                <h4 class="card-header bg-white" data-bind="text: company_name"></h4>
                <div class="card-body">
                    <h5 class="card-title" data-bind="text: title"></h5>
                    <p class="card-text my-0">仕事内容：<span data-bind="text: description"></span></p>
                    <p class="card-text my-0">応募条件：<span data-bind="text: requirements"></span></p>
                    <p class="card-text my-0">期間：<span data-bind="text: period"></span></p>
                    <p class="card-text my-0">給与・報酬：<span data-bind="text: salary"></span></p>
                    <div class="d-flex justify-content-between">
                        <a href="/student/login" class="btn btn-light border mt-2">詳細を見る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/knockout@3.5.1/build/output/knockout-latest.js"></script>
<script src="/assets/js/jobs.js"></script>
</body>
</html>
