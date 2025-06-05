<?php

// すべてのコントローラの共通処理を持つ基底クラス
class Controller_Base extends Controller
{
    // アクション実行前に毎回呼ばれる処理
    public function before()
    {
        parent::before();

        // 全ビューで使える共通変数を初期化（ログイン状態やユーザー名など）
        View::set_global('is_logged_in', false);
        View::set_global('user_name', "");
        View::set_global('user_type', "");

        // 学生としてログイン中かどうか判定
        if ($user_id = Session::get('user_id')) {
            $user = Model_User::find_by_id($user_id);
            if ($user) {
                // 学生ログイン状態をグローバルにセット
                View::set_global('is_logged_in', true);
                View::set_global('user_name', $user['name']);
                View::set_global('user_type', 'student');
            }
        }

        // 企業としてログイン中かどうか判定
        if ($company_id = Session::get('company_id')) {
            $company = Model_Company::find_by_id($company_id);
            if ($company) {
                // 企業ログイン状態をグローバルにセット（上書きされる）
                View::set_global('is_logged_in', true);
                View::set_global('user_name', $company['name']);
                View::set_global('user_type', 'company');
            }
        }
    }
}

?>
