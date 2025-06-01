<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <?= Form::open(['action' => '/company/register', 'method' => 'post']) ?>
            <div class="mb-3">
                <?= Form::label('企業名', 'name', ['class' => 'form-label']) ?>
                <?= Form::input('name', Input::post('name'), ['class' => 'form-control', 'id' => 'name']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('メールアドレス', 'email', ['class' => 'form-label']) ?>
                <?= Form::input('email', Input::post('email'), ['class' => 'form-control', 'id' => 'email', 'type' => 'email']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('パスワード', 'password', ['class' => 'form-label']) ?>
                <?= Form::password('password', null, ['class' => 'form-control', 'id' => 'password']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('企業情報', 'description', ['class' => 'form-label']) ?>
                <?= Form::input('description', Input::post('description'), ['class' => 'form-control', 'id' => 'description']) ?>
            <?= Form::submit('submit', '登録', ['class' => 'btn btn-dark']) ?>
        <?= Form::close() ?>
        <?php if (!empty($errors['name'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['name']) ?></div>
        <?php elseif (!empty($errors['email'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['email']) ?></div>
        <?php elseif (!empty($errors['password'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['password']) ?></div>
        <?php elseif (!empty($errors['description'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['description']) ?></div>
        <?php endif ?>
    </div>
</main>
</body>
</html>