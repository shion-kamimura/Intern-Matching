<?php

class Controller_public extends Controller_Base
{
    public function action_list()
    {
        $jobs = Model_Job::get_all();
        return Response::forge(View::forge('public/list', ['jobs' => $jobs]));
    }

}

?>