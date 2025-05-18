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
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php foreach ($jobs as $job): ?>
        <div class="container mb-5">
            <div class="card">
                <h4 class="card-header bg-white">
                    <?php echo $job['company_id'] ?>
                </h4>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $job['title'] ?></h5>
                    <p class="card-text my-0">仕事内容：<?php echo $job['description'] ?></p>
                    <p class="card-text my-0">応募条件：<?php echo $job['requirements'] ?></p>
                    <p class="card-text my-0">期間：<?php echo $job['period'] ?></p>
                    <p class="card-text my-0">給与・報酬：<?php echo $job['salary'] ?></p>
                    <a href="#" class="btn btn-light border mt-2">詳細を見る</a>
                    <a href="#" class="btn btn-dark mt-2">応募する</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>