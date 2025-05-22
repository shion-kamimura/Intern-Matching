<?= View::forge('header'); ?>
<main>
    <div class="container mt-5 mb-5 pt-5">
        <h1 class="h3">応募者一覧</h1>
    </div>
    <?php foreach ($applicants as $applicant): ?>
        <div class="container mb-5">
            <div class="card">
                <h4 class="card-header bg-white">
                    <?php echo $applicant['name'] ?>
                </h4>
                <div class="card-body">
                    <p class="card-text my-0">メールアドレス：<?php echo $applicant['email'] ?></p>
                    <p class="card-text my-0">学校：<?php echo $applicant['school'] ?></p>
                    <p class="card-text my-0">期間：<?php echo $applicant['grade'] ?></p>
                    <p class="card-text my-0">給与・報酬：<?php echo $applicant['skills'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</main>
</body>
</html>

