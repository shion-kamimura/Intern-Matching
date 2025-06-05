<?php

// 企業情報に関するDB操作をまとめたモデル
class Model_Company extends Model {

    // メールアドレスから企業情報を取得（ログイン時に使用）
    public static function find_by_email($email) {
        return DB::select()
                 ->from('companies')
                 ->where('email', $email)
                 ->execute()
                 ->current(); // 1件のみ取得
    }

    // IDから企業情報を取得（セッション復元時などに使用）
    public static function find_by_id($company_id) {
        return DB::select()
                 ->from('companies')
                 ->where('id', $company_id)
                 ->execute()
                 ->current(); // 1件のみ取得
    }

    // 新規企業をDBに登録（登録フォームからのPOST処理で使用）
    public static function create($data) {
        return DB::insert('companies')
                 ->set($data)
                 ->execute();
    }

    // 指定されたメールアドレスがすでに使われているか確認（バリデーション用）
    public static function is_email_taken($email) {
        return DB::select()
                 ->from('companies')
                 ->where('email', $email)
                 ->execute()
                 ->count() > 0;
    }
}

?>
