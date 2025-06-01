<?php

class MyRules
{
    public static function _validation_unique_user($email)
    {
        $exists = Model_User::is_email_taken($email);

        return !$exists;
    }

    public static function _validation_unique_company($email)
    {
        $exists = Model_Company::find_by_email($email);

        return !$exists;
    }
}

?>