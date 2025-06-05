<?php

// 独自バリデーションルールを定義するクラス
class MyRules
{
    // 学生のメールアドレスが既に登録済みかどうかを確認
    public static function _validation_unique_user($email)
    {
        // モデル経由で重複チェック
        $exists = Model_User::is_email_taken($email);

        // 登録されていなければ true を返す（バリデーション成功）
        return !$exists;
    }

    // 企業のメールアドレスが既に登録済みかどうかを確認
    public static function _validation_unique_company($email)
    {
        // モデル経由で重複チェック
        $exists = Model_Company::find_by_email($email);

        // 登録されていなければ true を返す（バリデーション成功）
        return !$exists;
    }
}

?>
