<?php

class Model_Like extends Model {

    public static function is_liked($user_id, $job_id) {
        return DB::select()->from('likes')->where('user_id', $user_id)->where('job_id', $job_id)->execute()->count() > 0;
    }

    public static function like($user_id, $job_id) {
        return DB::insert('likes')->set([
            'user_id' => $user_id,
            'job_id' => $job_id,
            'created_at' => Date::time()->format('mysql')
        ])->execute();
    }

    public static function unlike($user_id, $job_id) {
        return DB::delete('likes')->where('user_id', $user_id)->where('job_id', $job_id)->execute();
    }

}

?>