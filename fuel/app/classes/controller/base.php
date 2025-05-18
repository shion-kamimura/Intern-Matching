<?php

class Controller_Base extends Controller
{
    public function before()
    {
        parent::before();

        View::set_global('is_logged_in', false);
        View::set_global('user_name', "");
        View::set_global('user_type', "");
        
        if($user_id = Session::get('user_id')) {
            $user = DB::select()->from('users')->where('id', $user_id)->execute()->current();
            if($user) {
                View::set_global('is_logged_in', true);
                View::set_global('user_name', $user['name']);
                View::set_global('user_type', 'student');
            }
        }

        if ($company_id = Session::get('company_id')) {
            $company = DB::select()->from('companies')->where('id', $company_id)->execute()->current();
            if ($company) {
                View::set_global('is_logged_in', true);
                View::set_global('user_name', $company['name']);
                View::set_global('user_type', 'company');
            }
        }
    }
}