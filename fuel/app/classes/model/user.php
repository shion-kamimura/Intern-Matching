<?php

class Model_User extends Model {

    public static function find_by_email($email) {
        return DB::select()->from('users')->where('email', $email)->execute()->current();
    }

    public static function find_by_id($user_id) {
        return DB::select()->from('users')->where('id', $user_id)->execute()->current();
    }

    public static function create($data) {
        return DB::insert('users')->set($data)->execute();
    }

    public static function is_email_taken($email) {
        return DB::select()->from('users')->where('email', $email)->execute()->count() > 0;
    }

}

?>