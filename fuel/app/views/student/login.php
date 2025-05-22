<?= View::forge('header'); ?>

<main>
    <div class="container mt-5 mb-1 pt-5">
        <h1 class="h3">学生ログイン</h1>
    </div>
    <div class="container px-5 mt-5">
        <form method="post" action="/student/login">
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-dark">ログイン</button>
        </form>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mt-3"><?php e($error) ?></div>
        <?php endif; ?>
    </div>
    
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>