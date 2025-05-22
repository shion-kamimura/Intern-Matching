<?= View::forge('header'); ?>
<main>
    <div class="container mt-5 mb-5 pt-5">
        <h1 class="h3">応募者一覧</h1>
    </div>
    <?php if (empty($applicants)): ?>
        <div class="container">
            <p class="text-muted">まだ応募者がいません。</p>
        </div>
    <?php endif; ?>
    <?php foreach ($applicants as $applicant): ?>
        <div class="container mb-5">
            <div class="card">
                <h4 class="card-header bg-white">
                    <?php echo $applicant['name'] ?>
                </h4>
                <div class="card-body">
                    <p class="card-text my-0">メールアドレス：<?php echo e($applicant['email']) ?></p>
                    <p class="card-text my-0">学校：<?php echo e($applicant['school']) ?></p>
                    <p class="card-text my-0">学年：<?php echo e($applicant['grade']) ?></p>
                    <p class="card-text my-0">スキル：<?php echo e($applicant['skills']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</main>
</body>
</html>

