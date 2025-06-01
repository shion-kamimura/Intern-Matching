<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <?= Form::open(['action' => '/student/register', 'method' => 'post']) ?>
            <div class="mb-3">
                <?= Form::label('名前', 'name', ['class' => 'form-label']) ?>
                <?= Form::input('name', Input::post('name'), ['class' => 'form-control', 'id' => 'name']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('メールアドレス', 'email', ['class' => 'form-label']) ?>
                <?= Form::input('email', Input::post('email'), ['type' => 'email', 'class' => 'form-control', 'id' => 'email']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('パスワード', 'password', ['class' => 'form-label']) ?>
                <?= Form::password('password', null, ['class' => 'form-control', 'id' => 'password']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('学校名', 'school', ['class' => 'form-label']) ?>
                <?= Form::input('school', Input::post('school'), ['class' => 'form-control', 'id' => 'school']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('学年', 'grade', ['class' => 'form-label']) ?>
                <?= Form::input('grade', Input::post('grade'), ['class' => 'form-control', 'id' => 'grade']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('スキル', 'skills', ['class' => 'form-label']) ?>
                <?= Form::input('skills', Input::post('skills'), ['class' => 'form-control', 'id' => 'skills']) ?>
            </div>
            <?= Form::submit('submit', '登録', ['class' => 'btn btn-dark']) ?>
        <?= Form::close() ?>
        <?php if (!empty($errors['name'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['name']) ?></div>
        <?php elseif (!empty($errors['email'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['email']) ?></div>
        <?php elseif (!empty($errors['password'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['password']) ?></div>
        <?php elseif (!empty($errors['school'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['school']) ?></div>
        <?php elseif (!empty($errors['grade'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['grade']) ?></div>
        <?php elseif (!empty($errors['skills'])): ?>
            <div class="alert alert-danger mt-3"><?php echo e($errors['skills']) ?></div>
        <?php endif ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>