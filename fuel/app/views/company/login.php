<?= View::forge('header'); ?>

<main>
    <div class="container mt-5 mb-1 pt-5">
        <h1 class="h3">企業ログイン</h1>
    </div>
    <div class="container px-5 mt-5">
        <?= Form::open(['action' => '/company/login', 'method' => 'post']) ?>
            <div class="mb-3">
                <?= Form::label('メールアドレス', 'email', ['class' => 'form-label']) ?>
                <?= Form::input('email', Input::post('email'), ['type' => 'email', 'class' => 'form-control', 'id' => 'email', 'required']) ?>
            </div>
            <div class="mb-3">
                <?= Form::label('パスワード', 'password', ['class' => 'form-label']) ?>
                <?= Form::password('password', null, ['class' => 'form-control', 'id' => 'password']) ?>
            </div>
            <?= Form::submit('submit', 'ログイン', ['class' => 'btn btn-dark']) ?>
        <?= Form::close() ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mt-3"><?php echo e($error) ?></div>
        <?php endif; ?>
    </div>
    
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>