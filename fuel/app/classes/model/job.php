<?php

// インターン求人情報に関するDB操作をまとめたモデルクラス
class Model_Job extends Model {

    // すべての求人情報を取得（新着順）
    public static function get_all() {
        return DB::select('*')
                 ->from('jobs')
                 ->order_by('created_at', 'desc') // 新しい順に並べる
                 ->execute()
                 ->as_array();
    }

    // 特定企業が登録した求人一覧を取得
    public static function get_by_company($company_id) {
        return DB::select()
                 ->from('jobs')
                 ->where('company_id', $company_id)
                 ->order_by('created_at', 'desc')
                 ->execute()
                 ->as_array();
    }

    // IDから求人1件を取得（編集や応募詳細画面に使用）
    public static function find_by_id($id) {
        return DB::select()
                 ->from('jobs')
                 ->where('id', $id)
                 ->execute()
                 ->current(); // 1件のみ取得
    }

    // 新しい求人情報を登録
    public static function create($data) {
        return DB::insert('jobs')
                 ->set($data)
                 ->execute();
    }

    // 求人情報を更新（ID指定で）
    public static function update($id, $data) {
        return DB::update('jobs')
                 ->set($data)
                 ->where('id', $id)
                 ->execute();
    }

    // 求人IDで1件取得＋企業名も一緒に取得（学生向け詳細ページ用）
    public static function find_with_company($id) {
        return DB::select(
                    'jobs.id', 'jobs.title', 'jobs.description', 'jobs.period', 
                    'jobs.salary', 'jobs.requirements', 'jobs.created_at', 
                    'companies.name' // 企業名も取得
                )
                ->from('jobs')
                ->join('companies', 'LEFT')
                ->on('jobs.company_id', '=', 'companies.id')
                ->where('jobs.id', '=', $id)
                ->execute()
                ->current();
    }
}

?>
