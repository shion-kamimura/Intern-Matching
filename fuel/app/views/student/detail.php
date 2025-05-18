<?= View::forge('header'); ?>

<main>
    <div class="container mt-5 mb-5 pt-5">
        <h3><?php echo $job['name'] ?>：<?php echo $job['title'] ?></h3>
    </div>
    <div class="container mb-5">
        <h4>仕事内容</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo $job['description'] ?>
            </div>
        </div>
        <h4>応募条件</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo $job['requirements'] ?>
            </div>
        </div>
        <h4>期間</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo $job['period'] ?>
            </div>
        </div>
        <h4>給与・報酬</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo $job['salary'] ?>
            </div>
        </div>
        <button id="likeBtn" class="btn btn-outline-dark btn-sm no-hover mb-3">
            いいね
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5"/>
            </svg>
        </button>

        <?php if (Session::get_flash('success')): ?>
            <div class="alert alert-success"><?= Session::get_flash('success') ?></div>
        <?php endif; ?>
        <?php if (Session::get_flash('error')): ?>
            <div class="alert alert-danger"><?= Session::get_flash('error') ?></div>
        <?php endif; ?>
    </div>
</main>
<script src="/assets/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>