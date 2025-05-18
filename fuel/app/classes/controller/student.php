<?php

class Controller_Student extends Controller_Base
{
    public function action_login()
    {
        if (Input::method() === 'POST') {
            $email = Input::post('email');
            $password = Input::post('password');

            $user = DB::select()
                ->from('users')
                ->where('email', $email)
                ->where('password', $password)
                ->execute()
                ->current();

            if ($user) {
                Session::set('user_id', $user['id']);
                Session::set('user_name', $user['name']);
                Response::redirect('student/list');
            } else {
                $data['error'] = 'メールアドレスまたはパスワードが違います';
            }
        }    

        return Response::forge(View::forge('student/login', isset($data) ? $data : []));
    }

    public function post_login()
    {
        $email = Input::post('email');
        $password = Input::post('password');

        $user = DB::select()->from('users')->where('email', '=', $email)->execute()->current();

        if ($user && $user['password'] === $password) {
            Session::set('user_id', $user['id']);
            Response::redirect('/student/list');
        } else {
        
        }
    
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
        $name = Input::post('name');
        $email = Input::post('email');
        $password = Input::post('password');
        $school = Input::post('school');
        $grade = Input::post('grade');
        $skills = Input::post('skills');

        DB::insert('users')->set([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'school' => $school,
            'grade' => $grade,
            'skills' => $skills,
            'created_at' => Date::time()->format('mysql'),
        ])->execute();

        Response::redirect('student/login');
    }

    public function action_list()
    {
        $jobs = DB::select(
            'jobs.id', 'jobs.title', 'jobs.description', 'jobs.period',
            'jobs.salary', 'jobs.requirements', 'jobs.created_at',
            'companies.name'
            )
            ->from('jobs')
            ->join('companies', 'LEFT')
            ->on('jobs.company_id', '=', 'companies.id')
            ->order_by('jobs.created_at', 'desc')
            ->execute()
            ->as_array();
        return Response::forge(view::forge('student/list', ['jobs' => $jobs]));
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
        return Response::forge(View::forge('student/detail', ['job' => $job]));
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
}