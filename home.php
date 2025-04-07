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

<?php get_footer(); ?>