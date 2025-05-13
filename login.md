        <script>
    document.addEventListener('click', function(event) {
        // 1. ログイン済みユーザーは何もしない（WP の body_class() で 'logged-in' が付くので利用）
        if (document.body.classList.contains('logged-in')) return;

        // 2. 既にモーダル内をクリックした場合はスキップ
        if (event.target.closest('#loginModal .modal-content')) return;

        // 3. aタグやボタン、その他の遷移・アクションリンクを無視
        // ボタンの送信ボタンを除外する
        if (event.target.closest('a') || (event.target.closest('button') && !event.target.closest('button[type="submit"]'))) return;

        // それ以外のクリックならモーダルを表示
        const modalEl = document.getElementById('loginModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

    // モーダルの閉じる処理（オプション）
    document.addEventListener('click', function(event) {
        const loginModal = document.getElementById('loginModal');
        const modalContent = loginModal.querySelector('.modal-content');
        
        if (!modalContent.contains(event.target)) {
            const modal = bootstrap.Modal.getInstance(loginModal);
            modal.hide();
        }
    });
</script>