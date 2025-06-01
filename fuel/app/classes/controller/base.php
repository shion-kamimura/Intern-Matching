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
            $user = Model_User::find_by_id($user_id);
            if($user) {
                View::set_global('is_logged_in', true);
                View::set_global('user_name', $user['name']);
                View::set_global('user_type', 'student');
            }
        }

        if ($company_id = Session::get('company_id')) {
            $company = Model_Company::find_by_id($company_id);
            if ($company) {
                View::set_global('is_logged_in', true);
                View::set_global('user_name', $company['name']);
                View::set_global('user_type', 'company');
            }
        }
    }
}

?>