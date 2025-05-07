<?php

/**
 * フッター
 */
?>

</main> <!-- END .main -->
<footer class="footer">
    <a href="#" id="pageTop">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z" />
        </svg>
    </a>
    <section class="footer-upper">
        <div class="footer-upper-inner">
            <div class="is-row">
                <ul class="nav-wrapper">
                    <li><a href="<?php echo get_post_type_archive_link('news'); ?>" class="ttl_l">お知らせ一覧</a></li>
                    <li><a href="<?php echo home_url('/newscategory/allevent'); ?>" class="ttl_m">全体行事</a></li>
                    <li><a href="<?php echo home_url('/newscategory/company'); ?>" class="ttl_m">会社だより</a></li>
                    <li><a href="<?php echo home_url('/newscategory/obog'); ?>" class="ttl_m">OBOG会だより</a></li>
                    <li><a href="<?php echo home_url('/newscategory/member'); ?>" class="ttl_m">会員だより</a></li>
                </ul>
                <ul class="nav-wrapper">
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="ttl_l">中外炉OBOGクラブについて</a></li>
                    <li><a href="<?php echo home_url('/about#memberpost'); ?>" class="ttl_m">ご入稿について（会員限定）</a></li>
                    <li><a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank" class="ttl_m">弔事のご連絡について</a></li>
                </ul>
            </div>
            <figure class="is-corporate">
                <figcaption>公式サイトは <a href="https://chugai.co.jp/" target="_blank" rel="noopener noreferrer">こちら</a></figcaption>
                <img src="<?php echo get_template_directory_uri(); ?>/images/home/footer-banner-corporate.png" alt="コーポレートサイトのバナー">
            </figure>
        </div>
    </section>
    <section class="footer-bottom">
        <div class="footer-bottom-inner">
            <div class="is-row">
                <figure>
                    <img class="is-footerlogo" src="<?php echo get_template_directory_uri(); ?>/images/home/footer-logo.svg" alt="コーポレートサイトロゴ">
                </figure>
                <a href="https://twitter.com/CHUGAIRO_pr" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_logo_x.png" alt="エックスアイコン" class="sns_logo">
                </a>
                <a href="https://www.youtube.com/@chugairo9408" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_logo_youtube.png" alt="youtubeアイコン" class="sns_logo">
                </a>
            </div>
            <div class="is-copy">
                <small>&copy;Chugai Ro Co., Ltd. All rights reserved.</small>
            </div>
        </div>
    </section>

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<?php wp_footer(); ?>
</body>

</html>