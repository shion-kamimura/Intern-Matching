<?php

// 企業用のコントローラ。ログイン、登録、求人投稿、編集などを担当
class Controller_Company extends Controller_Base
{
    // 企業ログイン処理
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

            if ($val->run()) {
                // 入力が有効なら、DBから企業情報を検索
                $company = Model_Company::find_by_email($email);

                // パスワードを検証し、合っていればログイン成功
                if ($company && password_verify($password, $company['password'])) {
                    Session::set('company_id', $company['id']);
                    Session::set('user_name', $company['name']);
                    Session::set('user_type', 'company');
                    return Response::redirect('/company/dashboard');
                } else {
                    $data['error'] = 'メールアドレスまたはパスワードが間違っています。';
                }
            } else {
                $data['error'] = '入力に誤りがあります。正しいメールアドレスとパスワードを入力してください。';
            }
        }

        // GETまたはバリデーションエラー時にログイン画面を表示
        return Response::forge(View::forge('company/login', $data));
    }

    // ログアウト処理
    public function action_logout()
    {
        // セッション情報を削除
        Session::delete('company_id');
        Session::delete('user_name');
        Session::delete('user_type');
        return Response::redirect('/company/login');
    }

    // 登録画面の表示
    public function action_register()
    {
        return Response::forge(View::forge('company/register'));
    }

    // 企業登録の処理（POST）
    public function post_register()
    {
        // バリデーションの定義（独自ルールを含む）
        $val = Validation::forge();
        $val->add_callable(new MyRules());
        $val->add('name', '企業名')->add_rule('required')->add_rule('max_length', 100);
        $val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('unique_company');
        $val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 6);
        $val->add('description', '企業情報')->add_rule('required')->add_rule('max_length', 255);

        // バリデーション失敗時、エラー付きで再表示
        if (!$val->run()) {
            $errors = $val->error();
            return Response::forge(View::forge('company/register', ['errors' => $errors]));
        }

        // バリデーション成功時、DBに新規登録
        Model_Company::create([
            'name' => Input::post('name'),
            'email' => Input::post('email'),
            'password' => password_hash(Input::post('password'), PASSWORD_DEFAULT),
            'description' => Input::post('description'),
            'created_at' => Date::time()->format('mysql'),
        ]);

        Response::redirect('company/login');
    }

    // 企業ダッシュボード表示（自社の募集一覧）
    public function action_dashboard()
    {
        $company_id = Session::get('company_id');
        if (!$company_id) return Response::redirect('company/login');

        // 自社の求人情報を取得
        $jobs = Model_Job::get_by_company($company_id);

        return Response::forge(View::forge('company/dashboard', ['jobs' => $jobs]));
    }

    // 求人作成画面の表示
    public function action_create()
    {
        return Response::forge(View::forge('company/create'));
    }

    // 求人作成処理（POST）
    public function post_create()
    {
        $company_id = Session::get('company_id');

        if (!$company_id) {
            return Response::redirect('company/login');
        }

        // 入力バリデーション
        $val = Validation::forge();
        $val->add('title', 'タイトル')->add_rule('required');
        $val->add('description', '仕事内容')->add_rule('required');
        $val->add('period', '期間')->add_rule('required');
        $val->add('salary', '給与・報酬')->add_rule('required');
        $val->add('requirements', '応募条件')->add_rule('required');

        if (!$val->run()) {
            return Response::forge(View::forge('company/create', ['errors' => $val->error()]));
        }

        // 募集をデータベースに登録
        Model_Job::create([
            'company_id' => $company_id,
            'title' => Input::post('title'),
            'description' => Input::post('description'),
            'period' => Input::post('period'),
            'salary' => Input::post('salary'),
            'requirements' => Input::post('requirements'),
        ]);

        Response::redirect('company/dashboard');
    }

    // 求人編集画面の表示・更新
    public function action_edit($id = null)
    {
        if (!$id) return Response::redirect('/company/dashboard');

        // 対象求人を取得
        $job = Model_Job::find_by_id($id);
        if (!$job) return Response::redirect('/company/dashboard');

        // 権限チェック：自社の求人かどうか
        $company_id = Session::get('company_id');
        if ($job['company_id'] != $company_id) {
            Session::set_flash('error', 'この募集情報を編集する権限がありません');
            return Response::redirect('/company/dashboard');
        }

        // 編集処理（POST）
        if (Input::method() === 'POST') {
            $val = Validation::forge();
            $val->add('title', 'タイトル')->add_rule('required');
            $val->add('description', '仕事内容')->add_rule('required');
            $val->add('period', '期間')->add_rule('required');
            $val->add('salary', '給与・報酬')->add_rule('required');
            $val->add('requirements', '応募条件')->add_rule('required');

            if ($val->run()) {
                // DB更新
                Model_Job::update($id, [
                    'title' => Input::post('title'),
                    'description' => Input::post('description'),
                    'period' => Input::post('period'),
                    'salary' => Input::post('salary'),
                    'requirements' => Input::post('requirements'),
                ]);

                Session::set_flash('success', '募集情報を更新しました');
                return Response::redirect('/company/dashboard');
            } else {
                return Response::forge(View::forge('company/edit', ['job' => $job, 'errors' => $val->error()]));
            }
        }

        // GETの場合はフォームに既存情報を表示
        return Response::forge(View::forge('company/edit', ['job' => $job]));
    }

    // 応募者一覧の表示
    public function action_applicants($job_id)
    {
        $company_id = Session::get('company_id');
        if (!$company_id) return Response::redirect('company/login');

        // 指定求人に応募した学生一覧を取得
        $applicants = Model_Application::get_applicants($job_id, $company_id);

        return View::forge('company/applicants', ['applicants' => $applicants]);
    }
}
