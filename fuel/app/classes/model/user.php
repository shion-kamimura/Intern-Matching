<?php

// 学生ユーザーに関するDB操作をまとめたモデル
class Model_User extends Model {

    // メールアドレスからユーザー情報を1件取得（ログイン時に使用）
    public static function find_by_email($email) {
        return DB::select()
                 ->from('users')
                 ->where('email', $email)
                 ->execute()
                 ->current(); // 最初の1件のみ取得
    }

    // IDからユーザー情報を1件取得（セッションから復元などに使用）
    public static function find_by_id($user_id) {
        return DB::select()
                 ->from('users')
                 ->where('id', $user_id)
                 ->execute()
                 ->current(); // 最初の1件のみ取得
    }

    // 新しいユーザー情報をusersテーブルに登録
    public static function create($data) {
        return DB::insert('users')
                 ->set($data)
                 ->execute();
    }

    // メールアドレスがすでに登録されているか確認（登録バリデーションで使用）
    public static function is_email_taken($email) {
        return DB::select()
                 ->from('users')
                 ->where('email', $email)
                 ->execute()
                 ->count() > 0;
    }

}

?>
