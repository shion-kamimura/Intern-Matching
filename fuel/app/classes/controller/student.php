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
                $user = DB::select()
                    ->from('users')
                    ->where('email', $email)
                    ->execute()
                    ->current();

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

        $name = Input::post('name');
        $email = Input::post('email');
        $password = Input::post('password');
        $school = Input::post('school');
        $grade = Input::post('grade');
        $skills = Input::post('skills');

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        DB::insert('users')->set([
            'name' => $name,
            'email' => $email,
            'password' => $password_hashed,
            'school' => $school,
            'grade' => $grade,
            'skills' => $skills,
            'created_at' => Date::time()->format('mysql'),
        ])->execute();

        Response::redirect('student/login');
    }

    public function action_list()
    {
        return Response::forge(view::forge('student/list'));//, ['jobs' => $jobs]));
    }

    public function action_detail($id)
    {
        $job = DB::select(
            'jobs.id', 'jobs.title', 'jobs.description', 'jobs.period',
            'jobs.salary', 'jobs.requirements', 'jobs.created_at',
            'companies.name'
        )
            ->from('jobs')
            ->join('companies', 'LEFT')
            ->on('jobs.company_id', '=', 'companies.id')
            ->where('jobs.id', '=', $id)
            ->execute()
            ->current();

        $job_id = $job['id'];
        $user_id = Session::get('user_id');

        $is_liked = DB::select()
            ->from('likes')
            ->where('user_id', $user_id)
            ->where('job_id', $job_id)
            ->execute()
            ->count() > 0;

        return Response::forge(View::forge('student/detail', ['job' => $job, 'is_liked' => $is_liked, 'job_id' => $job_id]));
    }

    public function action_apply()
    {
        $user_id = Session::get('user_id');
        $job_id = Input::post('job_id');

        $exists = DB::select()
            ->from('applications')
            ->where('user_id', $user_id)
            ->and_where('job_id', $job_id)
            ->execute()
            ->count();

        if ($exists > 0) {                                                                                                                                                                                                                                                                                                                                                                   
            Session::set_flash('error', 'すでにこの求人に応募しています。');
            return Response::redirect("/student/detail/{$job_id}");
        }

        DB::insert('applications')->set([
            'user_id' => $user_id,
            'job_id' => $job_id,
            'created_at' => Date::time()->format('mysql'),
        ])->execute();

        Session::set_flash('success', '応募が完了しました！');
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
            DB::insert('likes')->set([
                'user_id' => $user_id,
                'job_id' => $job_id,
                'created_at' => date('Y-m-d H:i:s')
            ])->execute();
        } else {
            DB::delete('likes')
                ->where('user_id', $user_id)
                ->where('job_id', $job_id)
                ->execute();
        }

        return Response::forge(json_encode(['success' => true]), 200, ['Content-Type' => 'application/json']);
    }


}