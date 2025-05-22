<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">タイトル</label>
                <input type="text" name="title" class="form-control" value="<?php echo e($job['title']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">説明</label>
                <textarea name="description" class="form-control"><?php echo e($job['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">期間</label>
                <input type="text" name="period" class="form-control" value="<?php echo e($job['period']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">給与</label>
                <input type="text" name="salary" class="form-control" value="<?php echo e($job['salary']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">応募条件</label>
                <textarea name="requirements" class="form-control"><?php echo e($job['requirements']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-dark">更新</button>
        </form>
    </div>
</main>
</body>
</html>