<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <form method="post" action="/company/login">
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mt-"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-dark">ログイン</button>
        </form>
    </div>
</main>
</body>
</html>