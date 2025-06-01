<?php

class Controller_Student extends Controller_Base
{
    public function action_login()
    {
        $data = [];
        if (Input::method() === 'POST') {
            $email = Input::post('email');
            $password = Input::post('password');

            $val = Validation::forge();
            $val->add('email', 'Email')->add_rule('required')->add_rule('valid_email');
            $val->add('password', 'Password')->add_rule('required');

            if($val->run()) {
                $user = Model_User::find_by_email($email);

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
            
        return Response::forge(View::forge('student/login', $data));
    }

    public function action_logout()
    {
        Session::delete('user_id');
        Session::delete('user_name');
        Session::delete('user_type');
        return Response::redirect('/student/login');
    }


    public function action_register()
    {
        return Response::forge(View::forge('student/register'));
    }

    public function post_register()
    {
        $val = Validation::forge();
        $val->add_callable(new MyRules());
        $val->add('name', '名前')->add_rule('required')->add_rule('max_length', 100);
        $val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('unique_user');
        $val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 6);
        $val->add('school', '学校')->add_rule('required')->add_rule('max_length', 100);
        $val->add('grade', '学年')->add_rule('required');
        $val->add('skills', 'スキル')->add_rule('required');

        if (!$val->run()) {
            $errors = $val->error();
            return Response::forge(View::forge('student/register', ['errors' => $errors]));
        }

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

    public function action_list()
    {
        $user_id = Session::get('user_id');
        if (!$user_id) return Response::redirect('student/login');

        return Response::forge(View::forge('student/list'));
    }

    public function action_detail($id)
    {
        if (!$id) return Response::redirect('/student/list');

        $job = Model_Job::find_with_company($id);
        if (!$job) return Response::redirect('/student/list');

        $job_id = $job['id'];


        $user_id = Session::get('user_id');

        $is_liked = Model_Like::is_liked($user_id, $id);

        return Response::forge(View::forge('student/detail', ['job' => $job, 'is_liked' => $is_liked, 'job_id' => $job_id]));
    }

    public function action_apply()
    {
        $user_id = Session::get('user_id');
        $job_id = Input::post('job_id');

        if (Model_Application::exists($user_id, $job_id)) {
            Session::set_flash('error', 'すでにこの求人に応募しています。');
        } else {
            Model_Application::apply($user_id, $job_id);
            Session::set_flash('success', '応募が完了しました！');
        }
        return Response::redirect("/student/detail/{$job_id}");
    }

    public function action_like()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $user_id = Session::get('user_id');
        $job_id = $data['job_id'] ?? null;
        $action = $data['action'] ?? null;
        $liked = $action === 'like';

        if (!$user_id || !$job_id) {
            return Response::forge(json_encode(['success' => false]), 400, ['Content-Type' => 'application/json']);
        }

        if ($liked) {
            Model_Like::like($user_id, $job_id);
        } else {
            Model_Like::unlike($user_id, $job_id);
        }

        return Response::forge(json_encode(['success' => true]), 200, ['Content-Type' => 'application/json']);
    }


}