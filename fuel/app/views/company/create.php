<?= View::forge('header'); ?>

<main>
    <div class="container p-5 mt-5">
        <form method="post" action="/company/create">
            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">仕事内容</label>
                <textarea type="text" class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="period" class="form-label">期間</label>
                <input type="text" class="form-control" id="period" name="period">
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">給与・報酬</label>
                <input type="text" class="form-control" id="salary" name="salary">
            </div>
            <div class="mb-3">
                <label for="requirements" class="form-label">応募条件</label>
                <textarea type="text" class="form-control" id="requirements" name="requirements"></textarea>
            </div>
            <button type="submit" class="btn btn-dark">登録</button>
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