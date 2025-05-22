<?= View::forge('header'); ?>

<main>
    <div class="container m-5 p-5">
        <form method="post" action="/company/create">
            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">仕事内容</label>
                <input type="text" class="form-control" id="description" name="description">
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
                <input type="text" class="form-control" id="requirements" name="requirements">
            </div>
            <button type="submit" class="btn btn-dark">登録</button>
        </form>
    </div>
</main>
</body>
</html>