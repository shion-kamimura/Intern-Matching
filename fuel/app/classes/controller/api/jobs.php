<?php

// REST API用コントローラ：募集情報をJSONで返す
class Controller_Api_Jobs extends Controller_Rest
{
    // レスポンス形式をJSONに指定
    protected $format = 'json';

    // GET /api/jobs/list に対応：募集一覧取得API
    public function get_list()
    {
        // クエリパラメータ "sort" を取得（デフォルトは created_at）
        $sort = Input::get('sort', 'created_at');

        // ソート許可リスト：created_at または likes のみ
        $allowed_sorts = ['created_at', 'likes'];
        if (!in_array($sort, $allowed_sorts)) {
            $sort = 'created_at';
        }

        // 基本のクエリ：jobsテーブルとcompaniesテーブルをJOIN（企業名取得）
        $query = DB::select(
                'jobs.id',
                'jobs.title',
                'jobs.description',
                'jobs.period',
                'jobs.salary',
                'jobs.requirements',
                'jobs.created_at',
                ['companies.name', 'company_name'] // companies.name を company_name として取得
            )
            ->from('jobs')
            ->join('companies', 'LEFT')
            ->on('jobs.company_id', '=', 'companies.id');

        if ($sort === 'likes') {
            // いいね数でソートする場合：likesテーブルをJOINしてCOUNTを使って降順ソート
            $query->join('likes', 'LEFT')
                  ->on('jobs.id', '=', 'likes.job_id')
                  ->group_by(
                      'jobs.id', 'jobs.title', 'jobs.description', 'jobs.period',
                      'jobs.salary', 'jobs.requirements', 'jobs.created_at', 'companies.name'
                  )
                  ->order_by(DB::expr('COUNT(likes.id)'), 'desc');
        } else {
            // 作成日時での降順ソート（デフォルト）
            $query->order_by('jobs.' . $sort, 'desc');
        }

        // クエリ実行→配列に変換
        $jobs = $query->execute()->as_array();

        // JSON形式で返す
        return $this->response($jobs);
    }
}

?>
