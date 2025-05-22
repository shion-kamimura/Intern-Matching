<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <form method="post" action="/student/register">
            <div class="mb-3">
                <label for="name" class="form-label">名前</label>
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
                <label for="school" class="form-label">学校名</label>
                <input type="text" class="form-control" id="school" name="school">
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">学年</label>
                <input type="text" class="form-control" id="grade" name="grade">
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">スキル</label>
                <input type="text" class="form-control" id="skills" name="skills">
            </div>
            <button type="submit" class="btn btn-dark">登録</button>
        </form>
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