<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>インターン・企業マッチング</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom">
        <div class="container-fluid border-end">
            <a class="mx-2" href="
            <?php if(!$is_logged_in) echo '/public/list';
                elseif($user_type === 'student') echo '/student/list';
                elseif($user_type === 'company') echo '/company/dashboard';
            ?>
            ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black" class="bi bi-map" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.5.5 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103M10 1.91l-4-.8v12.98l4 .8zm1 12.98 4-.8V1.11l-4 .8zm-6-.8V1.11l-4 .8v12.98z"/>
                </svg>
            </a>
            <div class="ms-auto">
                <?php if(!$is_logged_in): ?>
                    <span class="mx-1">学生の方はこちら</span>
                    <a href="/student/login" class="btn btn-light btn-sm  border mx-1">ログイン</a>
                    <a href="/student/register" class="btn btn-dark btn-sm mx-1">登録</a>
                    <span class="mx-1">企業の方はこちら</span>
                    <a href="/company/login" class="btn btn-light btn-sm  border mx-1">ログイン</a>
                    <a href="/company/register" class="btn btn-dark btn-sm mx-1">登録</a>
                <?php else: ?>
                    <span class="me-3">こんにちは、<?php echo $user_name ?>さん</span>
                    <?php if($user_type === 'student'): ?>
                        <a href="/student/logout" class="btn btn-dark btn-sm mx-1">ログアウト</a>
                    <?php elseif($user_type === 'company'): ?>
                        <a href="/company/logout" class="btn btn-dark btn-sm mx-1">ログアウト</a>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    </nav>
</header>
