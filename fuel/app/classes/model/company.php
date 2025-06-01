<?php

class Model_Company extends Model {

    public static function find_by_email($email) {
        return DB::select()->from('companies')->where('email', $email)->execute()->current();
    }

    public static function find_by_id($company_id) {
        return DB::select()->from('companies')->where('id', $company_id)->execute()->current();
    }

    public static function create($data) {
        return DB::insert('companies')->set($data)->execute();
    }

    public static function is_email_taken($email) {
        return DB::select()->from('companies')->where('email', $email)->execute()->count() > 0;
    }

}

?>