document.addEventListener('DOMContentLoaded', function () {
    // HTML上にある job_id の値を取得（求人ID）
    const jobId = document.getElementById('job_id')?.value;
    // サーバー側から渡された初期状態（すでにいいね済みか）
    const initialLiked = window.initialLiked === true;

    if (!jobId) {
        console.error('job_id が見つかりませんでした。');
        return;
    }

    // CSRF対策：metaタグからトークンを取得（あれば）
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Knockout.jsのビューモデル定義
    class LikeViewModel {
        constructor() {
            // いいね状態（trueならハート赤、falseなら未いいね）
            this.isLiked = ko.observable(initialLiked);
            // 通信中フラグ（ボタン連打防止用）
            this.isLoading = ko.observable(false);
        }

        // いいね・取り消しの切り替え処理（サーバーにPOST）
        toggleLike = () => {
            if (this.isLoading()) return; // 処理中なら無視

            const liked = this.isLiked();
            this.isLoading(true); // 処理開始フラグON

            fetch('/student/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    ...(csrfToken && { 'X-CSRF-Token': csrfToken }) // トークンがあれば付加
                },
                body: JSON.stringify({
                    job_id: jobId,
                    action: liked ? 'unlike' : 'like' // 状態に応じて切り替え
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 成功時：状態を切り替える
                    this.isLiked(!liked);
                } else {
                    alert('操作に失敗しました。');
                }
            })
            .catch(error => {
                console.error('通信エラー:', error);
                alert('通信エラーが発生しました。');
            })
            .finally(() => {
                // 処理終了：ボタン再び押せるように
                this.isLoading(false);
            });
        }
    }

    // 対象HTML要素が存在すれば、Knockoutのバインディングを適用
    const likeButtonArea = document.getElementById('like-button-area');
    if (likeButtonArea) {
        const vm = new LikeViewModel();
        ko.applyBindings(vm, likeButtonArea);
    }
});
