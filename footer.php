<?php

/**
 * フッター
 */
?>

</main> <!-- END .main -->
<footer class="footer">
    <a href="#" id="pageTop">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"/>
        </svg>
    </a>
    <section class="footer-upper">
        <div>
            <ul>
                <li><a href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧</a></li>
                <li><a href="<?php echo home_url('/newscategory/allevent'); ?>">全体行事</a></li>
                <li><a href="<?php echo home_url('/newscategory/company'); ?>">会社だより</a></li>
                <li><a href="<?php echo home_url('/newscategory/obog'); ?>">OBOG会だより</a></li>
                <li><a href="<?php echo home_url('/newscategory/member'); ?>">会員だより</a></li>
            </ul>
            <ul>
                <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">OBOGクラブについて</a></li>
                <li>ご入稿について（会員限定）</li>
                <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">弔事のご連絡について</a></li>
            </ul>
        </div>
        <figure class="is-corporate">
            <figcaption>公式サイトはこちら</figcaption>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home/footer-banner-corporate.png" alt="コーポレートサイトのバナー">
        </figure>
    </section>
    <section class="footer-bottom">
        <div class="is-row">
            <figure>
                <img class="is-footerlogo" src="<?php echo get_template_directory_uri(); ?>/images/home/footer-logo.png" alt="コーポレートサイトロゴ">
            </figure>
            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_x.png" alt="エックスアイコン">
            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_youtube.png" alt="youtubeアイコン">
        </div>
        <div class="is-copy">
            <small>&copy;Chugai Ro Co., Ltd. All rights reserved.</small>
        </div>
    </section>
    
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("loginBtn").addEventListener("click", function() {
        // メールアドレスとパスワードの値を取得
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        // 認証成功条件（追加したメールアドレス）
        const validEmails = [
            "lumikojo@ikkosha.co.jp",
            "k_minamimoto@ikkosha.co.jp",
            "take_iwata@ikkosha.co.jp",
            "tanigake@ikkosha.co.jp"
        ];

        // パスワードが一致し、かつメールアドレスがリストに含まれている場合
        if (validEmails.includes(email) && password === "1922") {
            // 認証成功 → archive.html に遷移
            window.location.href = "archive.html";
        } else {
            // 認証失敗 → エラーメッセージを表示
            alert("メールアドレスまたはパスワードが間違っています。");
        }
    });
</script>

<?php wp_footer(); ?>
</body>

</html>