<?php

class Controller_public extends Controller_Base
{
     // 募集一覧ページの表示処理（誰でも見られる）
    public function action_list()
    {
        $jobs = Model_Job::get_all();
        return Response::forge(View::forge('public/list', ['jobs' => $jobs]));
    }

}

?>