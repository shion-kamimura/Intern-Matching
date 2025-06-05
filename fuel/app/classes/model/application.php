<?php

// 応募に関する処理をまとめたモデルクラス
class Model_Application extends Model {

    // 指定された学生がすでにその求人に応募しているかを確認
    public static function exists($user_id, $job_id) {
        return DB::select()
                 ->from('applications')
                 ->where('user_id', $user_id)
                 ->and_where('job_id', $job_id)
                 ->execute()
                 ->count() > 0;
    }

    // 学生の応募情報を applications テーブルに登録
    public static function apply($user_id, $job_id) {
        return DB::insert('applications')
                 ->set([
                     'user_id' => $user_id,
                     'job_id' => $job_id,
                     'created_at' => Date::time()->format('mysql') // 応募日時を記録
                 ])
                 ->execute();
    }

    // 応募者の情報を取得（企業の求人に対して応募した学生の一覧）
    public static function get_applicants($job_id, $company_id) {
        return DB::select(
                    'users.id', 'users.name', 'users.email', 
                    'users.school', 'users.grade', 'users.skills', 
                    'applications.created_at'
                )
                ->from('applications')
                ->join('users', 'INNER')->on('applications.user_id', '=', 'users.id')   // 応募者情報の結合
                ->join('jobs', 'INNER')->on('applications.job_id', '=', 'jobs.id')     // 募集情報の結合
                ->where('applications.job_id', $job_id)
                ->and_where('jobs.company_id', $company_id)  // 自社の求人に対する応募だけを取得
                ->execute()
                ->as_array();
    }
}

?>
