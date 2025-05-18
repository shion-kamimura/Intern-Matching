<?php

class Controller_public extends Controller_Base
{
    public function action_list()
    {
        $jobs = DB::select('*')->from('jobs')->order_by('created_at', 'desc')->execute()->as_array();
        return Response::forge(view::forge('public/list', ['jobs' => $jobs]));
    }

    public function action_logout()
    {
        if (Session::get('user_type') === 'student') {
            Session::delete('user_id');
            Session::delete('user_type');
            Session::delete('user_name');
            return Response::redirect('/student/login');
        }

        if (Session::get('user_type') === 'company') {
            Session::delete('company_id');
            Session::delete('user_type');
            Session::delete('user_name');
            return Response::redirect('/company/login');
        }

        return Response::redirect('/');
    }

}

