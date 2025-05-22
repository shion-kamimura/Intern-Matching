<?= View::forge('header'); ?>

<main>
    <div class="container p-5 mt-5">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">タイトル</label>
                <input type="text" name="title" class="form-control" value="<?php echo e($job['title']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">仕事内容</label>
                <textarea name="description" class="form-control"><?php echo e($job['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">期間</label>
                <input type="text" name="period" class="form-control" value="<?php echo e($job['period']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">給与・報酬</label>
                <input type="text" name="salary" class="form-control" value="<?php echo e($job['salary']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">応募条件</label>
                <textarea name="requirements" class="form-control"><?php echo e($job['requirements']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-dark">更新</button>
        </form>
        <?php if (!empty($errors['title'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['title']) ?></div>
        <?php elseif (!empty($errors['description'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['description']) ?></div>
        <?php elseif (!empty($errors['period'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['period']) ?></div>
        <?php elseif (!empty($errors['salary'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['salary']) ?></div>
        <?php elseif (!empty($errors['requirements'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['requirements']) ?></div>
        <?php endif ?>
    </div>
</main>
</body>
</html>