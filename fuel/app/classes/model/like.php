<?php

// 学生ユーザーの「いいね」機能を扱うモデル
class Model_Like extends Model {

    // 学生がその求人をすでにいいねしているかどうかを判定
    public static function is_liked($user_id, $job_id) {
        return DB::select()
                 ->from('likes')
                 ->where('user_id', $user_id)
                 ->where('job_id', $job_id)
                 ->execute()
                 ->count() > 0;
    }

    // いいねを追加（likes テーブルに新規レコードを挿入）
    public static function like($user_id, $job_id) {
        return DB::insert('likes')
                 ->set([
                     'user_id' => $user_id,
                     'job_id' => $job_id,
                     'created_at' => Date::time()->format('mysql') // いいね日時を記録
                 ])
                 ->execute();
    }

    // いいねを取り消す（likes テーブルからレコード削除）
    public static function unlike($user_id, $job_id) {
        return DB::delete('likes')
                 ->where('user_id', $user_id)
                 ->where('job_id', $job_id)
                 ->execute();
    }

}

?>
