<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <form method="post" action="/company/register">
            <div class="mb-3">
                <label for="name" class="form-label">企業名</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">企業情報</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
            <button type="submit" class="btn btn-dark">登録</button>
        </form>
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