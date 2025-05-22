document.addEventListener('DOMContentLoaded', function () {
    const jobId = document.getElementById('job_id')?.value;
    const initialLiked = window.initialLiked === true;

    if (!jobId) {
        console.error('job_id が見つかりませんでした。');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    class LikeViewModel {
        constructor() {
            this.isLiked = ko.observable(initialLiked);
            this.isLoading = ko.observable(false);
        }

        toggleLike = () => {
            if (this.isLoading()) return;

            const liked = this.isLiked();
            this.isLoading(true);

            fetch('/student/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    ...(csrfToken && { 'X-CSRF-Token': csrfToken })
                },
                body: JSON.stringify({
                    job_id: jobId,
                    action: liked ? 'unlike' : 'like'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
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
                this.isLoading(false);
            });
        }
    }

    const likeButtonArea = document.getElementById('like-button-area');
    if (likeButtonArea) {
        const vm = new LikeViewModel();
        ko.applyBindings(vm, likeButtonArea);
    }
});
