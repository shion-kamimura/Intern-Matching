<?php

class Controller_Api_Jobs extends Controller_Rest
{
    protected $format = 'json';

    public function get_list()
    {
        $sort = Input::get('sort', 'created_at');
        $allowed_sorts = ['created_at', 'likes'];

        if (!in_array($sort, $allowed_sorts)) {
            $sort = 'created_at';
        }

        $query = DB::select(
                'jobs.id',
                'jobs.title',
                'jobs.description',
                'jobs.period',
                'jobs.salary',
                'jobs.requirements',
                'jobs.created_at',
                ['companies.name', 'company_name']
            )
            ->from('jobs')
            ->join('companies', 'LEFT')
            ->on('jobs.company_id', '=', 'companies.id');

        if ($sort === 'likes') {
            // likes テーブルが存在し、job_id が FK である前提
            $query->join('likes', 'LEFT')
                  ->on('jobs.id', '=', 'likes.job_id')
                  ->group_by(
                      'jobs.id', 'jobs.title', 'jobs.description', 'jobs.period',
                      'jobs.salary', 'jobs.requirements', 'jobs.created_at', 'companies.name'
                  )
                  ->order_by(DB::expr('COUNT(likes.id)'), 'desc');
        } else {
            $query->order_by('jobs.' . $sort, 'desc');
        }

        $jobs = $query->execute()->as_array();

        return $this->response($jobs);
    }
}

?>
