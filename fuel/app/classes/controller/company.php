<?php

class Controller_Company extends Controller_Base
{
    public function action_login()
    {
        if (Input::method() === 'POST') {
            $email = Input::post('email');
            $password = Input::post('password');

            $company = DB::select()
                ->from('companies')
                ->where('email', $email)
                ->execute()
                ->current();

            if (!$company) {
                $data['error'] = 'そのメールアドレスのアカウントは見つかりませんでした。';
            } elseif ($company['password'] !== $password) {
                $data['error'] = 'パスワードが間違っています。';
            } else {
                Session::set('company_id', $company['id']);
                Session::set('user_name', $company['name']);
                Session::set('user_type', 'company');
                return Response::redirect('/company/dashboard');
            }
        }    

        return Response::forge(View::forge('company/login', isset($data) ? $data : []));
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
        $name = Input::post('name');
        $email = Input::post('email');
        $password = Input::post('password');
        $description = Input::post('description');

        DB::insert('companies')->set([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'description' => $description,
            'created_at' => Date::time()->format('mysql'),
        ])->execute();

        Response::redirect('company/login');
    }

    public function action_dashboard()
    {   
        $company_id = Session::get('company_id');

        if (!$company_id) {
            return Response::redirect('company/login');
        }

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

        $title = Input::post('title');
        $description = Input::post('description');
        $period = Input::post('period');
        $salary = Input::post('salary');
        $requirements = Input::post('requirements');

        DB::insert('jobs')->set([
            'company_id' => $company_id,
            'title' => $title,
            'description' => $description,
            'period' => $period,
            'salary' => $salary,
            'requirements' => $requirements,
            'created_at' => Date::time()->format('mysql'),
        ])->execute();

        Response::redirect('company/dashboard');
    }

    public function action_edit()
    {
        $job = DB::select()->from('jobs')->where('id', $id)->execute()->current();

        if (Input::method() === 'POST') {
            $title = Input::post('title');
            $description = Input::post('description');
            $period = Input::post('period');
            $salary = Input::post('salary');
            $requirements = Input::post('requirements');

            DB::update('jobs')->set([
                'title' => $title,
                'description' => $description,
                'period' => $period,
                'salary' => $salary,
                'requirements' => $requirements,
            ])->where('id', $id)->execute();

            Session::set_flash('success', '募集情報を更新しました');
            return Response::redirect('/company/dashboard');
        }

        return Response::forge(View::forge('company/edit', ['job' => $job]));
    }

}