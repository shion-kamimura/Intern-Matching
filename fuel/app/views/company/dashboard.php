<?= View::forge('header'); ?>

<main>
    <div class="container mt-5 mb-5 pt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3">応募一覧</h1>
            <a href="/company/create" class="btn btn-dark mt-2">作成する</a>
        </div>
    </div>
    <?php if (empty($jobs)): ?>
        <div class="container">
            <p class="text-muted">まだ求人が作成されていません。</p>
        </div>
    <?php endif; ?>
    <?php foreach ($jobs as $job): ?>
        <div class="container mb-5">
            <div class="card">
                <h4 class="card-header bg-white">
                    <?php echo e($job['id']) ?>
                </h4>
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($job['title']) ?></h5>
                    <p class="card-text my-0">仕事内容：<?php echo e($job['description']) ?></p>
                    <p class="card-text my-0">応募条件：<?php echo e($job['requirements']) ?></p>
                    <p class="card-text my-0">期間：<?php echo e($job['period']) ?></p>
                    <p class="card-text my-0">給与・報酬：<?php echo e($job['salary']) ?></p>
                    <a href="/company/applicants/<?php echo e($job['id']); ?>" class="btn btn-light mt-2">応募者一覧</a>
                    <a href="/company/edit/<?php echo e($job['id']) ?>" class="btn btn-dark mt-2">編集する</a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
