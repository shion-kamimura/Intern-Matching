<?php

class Controller_public extends Controller_Base
{
    public function action_list()
    {
        $jobs = DB::select('*')->from('jobs')->order_by('created_at', 'desc')->execute()->as_array();
        return Response::forge(View::forge('public/list', ['jobs' => $jobs]));
    }

}

?>