<?= View::forge('header'); ?>

<main>
    <div class="container p-5 mt-5">
        <?= Form::open(['action' => '/company/create', 'method' => 'post']) ?>
            <div class="mb-3">
                <?= Form::label('タイトル', 'title', ['class' => 'form-label']) ?>
                <?= Form::input('title', Input::post('title'), ['class' => 'form-control', 'id' => 'title']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('仕事内容', 'description', ['class' => 'form-label']) ?>
                <?= Form::textarea('description', Input::post('description'), ['class' => 'form-control', 'id' => 'description']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('期間', 'period', ['class' => 'form-label']) ?>
                <?= Form::input('period', Input::post('period'), ['class' => 'form-control', 'id' => 'period']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('給与・報酬', 'salary', ['class' => 'form-label']) ?>
                <?= Form::input('salary', Input::post('salary'), ['class' => 'form-control', 'id' => 'salary']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('応募条件', 'requirements', ['class' => 'form-label']) ?>
                <?= Form::textarea('requirements', Input::post('requirements'), ['class' => 'form-control', 'id' => 'requirements']) ?>
            <?= Form::submit('submit', '登録', ['class' => 'btn btn-dark']) ?>
        <?= Form::close() ?>
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