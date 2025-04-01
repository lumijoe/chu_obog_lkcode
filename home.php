<?php

/**
 * トップページ
 */
get_header();
?>

<h1>OBOGクラブ</h1>
<!-- <div class="container">
        <h1 class="text-primary">test</h1>
        <button class="btn btn-primary">クリック</button>
    </div> -->
<div class="container text-center mt-5">
    <!-- 一般ボタン -->
    <button class="btn btn-primary">一般ボタン</button>

    <!-- 会員ページボタン（ログインモーダルを開く） -->
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">会員ページ</button>
</div>

<!-- ログインモーダル -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">会員ログイン</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="email" class="form-control" id="email" placeholder="example@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">パスワード</label>
                        <input type="password" class="form-control" id="password" placeholder="••••••••">
                    </div>
                    <button type="button" class="btn btn-primary w-100" id="loginBtn">ログイン</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>