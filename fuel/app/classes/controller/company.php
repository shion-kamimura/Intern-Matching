<?php

class Controller_Company extends Controller_Base
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

            if ($val->run()) {
                $company = Model_Company::find_by_email($email);

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

        return Response::forge(View::forge('company/login', $data));
    }

    public function action_logout()
    {
        Session::delete('company_id');
        Session::delete('user_name');
        Session::delete('user_type');
        return Response::redirect('/company/login');
    }

    public function action_register()
    {
        return Response::forge(View::forge('company/register'));
    }

    public function post_register()
    {
        $val = Validation::forge();
        $val->add_callable(new MyRules());
        $val->add('name', '企業名')->add_rule('required')->add_rule('max_length', 100);
        $val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('unique_company');
        $val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 6);
        $val->add('description', '企業情報')->add_rule('required')->add_rule('max_length', 255);
        
        if (!$val->run()) {
            $errors = $val->error();
            return Response::forge(View::forge('company/register', ['errors' => $errors]));
        }
        
        Model_Company::create([
            'name' => Input::post('name'),
            'email' => Input::post('email'),
            'password' => password_hash(Input::post('password'), PASSWORD_DEFAULT),
            'description' => Input::post('description'),
            'created_at' => Date::time()->format('mysql'),
        ]);

        Response::redirect('company/login');
    }

    public function action_dashboard()
    {   
        $company_id = Session::get('company_id');
        if (!$company_id) return Response::redirect('company/login');

        $jobs = DB::select()
            ->from('jobs')
            ->where('company_id', $company_id)
            ->order_by('created_at', 'desc')
            ->execute()
            ->as_array();

        return Response::forge(View::forge('company/dashboard', ['jobs' => $jobs]));

    }

    public function action_create()
    {
        return Response::forge(View::forge('company/create'));
    }

    public function post_create()
    {
        $company_id = Session::get('company_id');

        if (!$company_id) {
            return Response::redirect('company/login');
        }

        $val = Validation::forge();
        $val->add('title', 'タイトル')->add_rule('required');
        $val->add('description', '仕事内容')->add_rule('required');
        $val->add('period', '期間')->add_rule('required');
        $val->add('salary', '給与・報酬')->add_rule('required');
        $val->add('requirements', '応募条件')->add_rule('required');

        if (!$val->run()) {
            return Response::forge(View::forge('company/create', ['errors' => $val->error()]));
        }

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

    public function action_edit($id = null)
    {
        if (!$id) return Response::redirect('/company/dashboard');

        $job = Model_Job::find_by_id($id);

        if (!$job) return Response::redirect('/company/dashboard');

        $company_id = Session::get('company_id'); 
        if ($job['company_id'] != $company_id) {
            Session::set_flash('error', 'この募集情報を編集する権限がありません');
            return Response::redirect('/company/dashboard');
        }

        if (Input::method() === 'POST') {
            $val = Validation::forge();
            $val->add('title', 'タイトル')->add_rule('required');
            $val->add('description', '仕事内容')->add_rule('required');
            $val->add('period', '期間')->add_rule('required');
            $val->add('salary', '給与・報酬')->add_rule('required');
            $val->add('requirements', '応募条件')->add_rule('required');

            if ($val->run()) {
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

        return Response::forge(View::forge('company/edit', ['job' => $job]));
    }

    public function action_applicants($job_id)
    {
        $company_id = Session::get('company_id');
        if (!$company_id) return Response::redirect('company/login');

        $applicants = Model_Application::get_applicants($job_id, $company_id);

        return View::forge('company/applicants', ['applicants' => $applicants]);
    }

}