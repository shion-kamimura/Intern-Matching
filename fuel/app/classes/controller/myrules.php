<?php

class MyRules
{
    public function _validation_unique_user($email)
    {   
        $exists = DB::select()
        ->from('users')
        ->where('email', $email)
        ->execute()
        ->count();

        return $exists === 0;
    }

    public function _validation_unique_company($email)
    {
        $exists = DB::select()
            ->from('companies')
            ->where('email', $email)
            ->execute()
            ->count();

        return $exists === 0;   
    }
}

?>