<?php

class Model_Job extends Model {

    public static function get_all() {
        return DB::select('*')->from('jobs')->order_by('created_at', 'desc')->execute()->as_array();
    }

    public static function get_by_company($company_id) {
        return DB::select()->from('jobs')->where('company_id', $company_id)->order_by('created_at', 'desc')->execute()->as_array();
    }

    public static function find_by_id($id) {
        return DB::select()->from('jobs')->where('id', $id)->execute()->current();
    }

    public static function create($data) {
        return DB::insert('jobs')->set($data)->execute();
    }

    public static function update($id, $data) {
        return DB::update('jobs')->set($data)->where('id', $id)->execute();
    }

    public static function find_with_company($id) {
        return DB::select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.period', 'jobs.salary', 'jobs.requirements', 'jobs.created_at', 'companies.name')
            ->from('jobs')
            ->join('companies', 'LEFT')->on('jobs.company_id', '=', 'companies.id')
            ->where('jobs.id', '=', $id)
            ->execute()
            ->current();
    }

}

?>