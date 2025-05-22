<?= View::forge('header'); ?>

<main>
    <div class="container mt-5 mb-5 pt-5">
        <h3><?php echo e($job['name']) ?>：<?php echo e($job['title']) ?></h3>
    </div>
    <div class="container mb-5">
        <h4>仕事内容</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo e($job['description']) ?>
            </div>
        </div>
        <h4>応募条件</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo e($job['requirements']) ?>
            </div>
        </div>
        <h4>期間</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo e($job['period']) ?>
            </div>
        </div>
        <h4>給与・報酬</h4>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo e($job['salary']) ?>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <div id="like-button-area">
                <input type="hidden" id="job_id" value="<?php echo e($job['id']) ?>">

                <button type="button"
                    class="btn"
                    data-bind="
                        css: {
                            'btn-outline-dark': !isLiked(),
                            'btn-dark': isLiked()
                        },
                        click: toggleLike
                    ">
                    <span data-bind="text: 'いいね♡'"></span>
                </button>
            </div>
            <form action="/student/apply" method="post">
                <input type="hidden" name="job_id" value="<?php echo e($job['id']) ?>">
                <button type="submit" class="btn btn-dark mt-3">応募する</button>
            </form>
        </div>

        <script>
            window.initialLiked = <?= $is_liked ? 'true' : 'false' ?>;
        </script>

        <?php if (Session::get_flash('success')): ?>
            <div class="alert alert-success"><?php echo e(Session::get_flash('success')) ?></div>
        <?php endif; ?>
        <?php if (Session::get_flash('error')): ?>
            <div class="alert alert-danger"><?php echo e(Session::get_flash('error')) ?></div>
        <?php endif; ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/knockout@3.5.1/build/output/knockout-latest.js"></script>
<script src="/assets/js/like.js"></script>
</body>
</html>