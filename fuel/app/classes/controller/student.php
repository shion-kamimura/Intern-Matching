<?php

// 学生ユーザー用のコントローラ（ログイン・応募・いいねなど）
class Controller_Student extends Controller_Base
{
    // 学生ログイン処理
    public function action_login()
    {
        $data = [];

        if (Input::method() === 'POST') {
            $email = Input::post('email');
            $password = Input::post('password');

            // 入力値のバリデーション
            $val = Validation::forge();
            $val->add('email', 'Email')->add_rule('required')->add_rule('valid_email');
            $val->add('password', 'Password')->add_rule('required');

            if($val->run()) {
                // メールアドレスから学生情報を取得
                $user = Model_User::find_by_email($email);

                // パスワード認証が成功すればログイン
                if ($user && password_verify($password, $user['password'])) {
                    Session::set('user_id', $user['id']);
                    Session::set('user_name', $user['name']);
                    Session::set('user_type', 'student');
                    Response::redirect('student/list');
                } else {
                    $data['error'] = 'メールアドレスまたはパスワードが違います';
                }
            } else {
                $data['error'] = '入力に誤りがあります。正しいメールアドレスとパスワードを入力してください。';
            }
        }

        // ログインフォームを表示（エラー情報付き）
        return Response::forge(View::forge('student/login', $data));
    }

    // ログアウト処理（セッション削除）
    public function action_logout()
    {
        Session::delete('user_id');
        Session::delete('user_name');
        Session::delete('user_type');
        return Response::redirect('/student/login');
    }

    // 学生登録画面の表示
    public function action_register()
    {
        return Response::forge(View::forge('student/register'));
    }

    // 学生登録処理（POST）
    public function post_register()
    {
        // 入力バリデーション（独自ルール unique_user を含む）
        $val = Validation::forge();
        $val->add_callable(new MyRules());
        $val->add('name', '名前')->add_rule('required')->add_rule('max_length', 100);
        $val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('unique_user');
        $val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 6);
        $val->add('school', '学校')->add_rule('required')->add_rule('max_length', 100);
        $val->add('grade', '学年')->add_rule('required');
        $val->add('skills', 'スキル')->add_rule('required');

        if (!$val->run()) {
            // バリデーションエラー時は再表示
            $errors = $val->error();
            return Response::forge(View::forge('student/register', ['errors' => $errors]));
        }

        // ハッシュ化されたパスワードと共にユーザー登録
        $user_data = [
            'name' => Input::post('name'),
            'email' => Input::post('email'),
            'password' => password_hash(Input::post('password'), PASSWORD_DEFAULT),
            'school' => Input::post('school'),
            'grade' => Input::post('grade'),
            'skills' => Input::post('skills'),
            'created_at' => Date::time()->format('mysql'),
        ];
        Model_User::create($user_data);

        Response::redirect('student/login');
    }

    // 募集一覧画面（ログイン済みでないとアクセス不可）
    public function action_list()
    {
        $user_id = Session::get('user_id');
        if (!$user_id) return Response::redirect('student/login');

        return Response::forge(View::forge('student/list'));
    }

    // 募集詳細の表示（+いいね状態）
    public function action_detail($id)
    {
        if (!$id) return Response::redirect('/student/list');

        // 募集情報＋企業情報を取得
        $job = Model_Job::find_with_company($id);
        if (!$job) return Response::redirect('/student/list');

        $job_id = $job['id'];
        $user_id = Session::get('user_id');

        // 学生がこの求人をいいね済みかどうか
        $is_liked = Model_Like::is_liked($user_id, $id);

        return Response::forge(View::forge('student/detail', [
            'job' => $job,
            'is_liked' => $is_liked,
            'job_id' => $job_id
        ]));
    }

    // 応募処理（同じ求人に重複応募できない）
    public function action_apply()
    {
        $user_id = Session::get('user_id');
        $job_id = Input::post('job_id');

        // すでに応募済みかチェック
        if (Model_Application::exists($user_id, $job_id)) {
            Session::set_flash('error', 'すでにこの求人に応募しています。');
        } else {
            Model_Application::apply($user_id, $job_id);
            Session::set_flash('success', '応募が完了しました！');
        }

        return Response::redirect("/student/detail/{$job_id}");
    }

    // Ajaxによる「いいね」送信処理
    public function action_like()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $user_id = Session::get('user_id');
        $job_id = $data['job_id'] ?? null;
        $action = $data['action'] ?? null;
        $liked = $action === 'like';

        // 不正リクエスト対策：IDが欠けていればエラー返却
        if (!$user_id || !$job_id) {
            return Response::forge(json_encode(['success' => false]), 400, ['Content-Type' => 'application/json']);
        }

        // いいね登録 or いいね解除
        if ($liked) {
            Model_Like::like($user_id, $job_id);
        } else {
            Model_Like::unlike($user_id, $job_id);
        }

        // 成功レスポンスをJSONで返却
        return Response::forge(json_encode(['success' => true]), 200, ['Content-Type' => 'application/json']);
    }
}
