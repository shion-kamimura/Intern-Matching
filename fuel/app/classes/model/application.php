<?php

class Model_Application extends Model {

    public static function exists($user_id, $job_id) {
        return DB::select()->from('applications')->where('user_id', $user_id)->and_where('job_id', $job_id)->execute()->count() > 0;
    }

    public static function apply($user_id, $job_id) {
        return DB::insert('applications')->set([
            'user_id' => $user_id,
            'job_id' => $job_id,
            'created_at' => Date::time()->format('mysql')
        ])->execute();
    }

    public static function get_applicants($job_id, $company_id) {
        return DB::select('users.id', 'users.name', 'users.email', 'users.school', 'users.grade', 'users.skills', 'applications.created_at')
            ->from('applications')
            ->join('users', 'INNER')->on('applications.user_id', '=', 'users.id')
            ->join('jobs', 'INNER')->on('applications.job_id', '=', 'jobs.id')
            ->where('applications.job_id', $job_id)
            ->and_where('jobs.company_id', $company_id)
            ->execute()
            ->as_array();
    }

}

?>