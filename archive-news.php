<!-- カスタム投稿の一覧 -->
<?php get_header(); ?>
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
        </ol>
    </nav>
</section>

<!-- titleview -->
<section class="l-titleview">
    <img src="<?php echo get_template_directory_uri(); ?>/images/common/img_page_news.png" alt="お知らせ一覧のページビュー">
    <div class="l-titleview-ttl">
        <p>お知らせ一覧ページ</p>
        <small>全てのお知らせをご案内しています</small>
    </div>
</section>

<!-- カテゴリタブ -->
<div class="l-category-tab">
    <button class="is-current"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></button>
    <button><a href="<?php echo home_url('/newscategory/allevent/'); ?>">全体行事</a></button>
    <button><a href="<?php echo home_url('/newscategory/company/'); ?>">会社だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/obog/'); ?>">OBOG会だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/member/'); ?>">会員だより</a></button>
</div>

<!-- サイドバー -->
<div class="l-side-grid">
    <!-- 記事セクション -->
    <section class="l-article">
        <?php if (have_posts()) : ?>
            <ul>
                <?php while (have_posts()) : the_post(); ?>
                    <li>
                         <!-- ACF投稿日時 -->
                         <date class="post-date"><?php echo get_the_date('Y.m.d'); ?></date>

                        <!-- カテゴリ表示 -->
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'newscategory');
                        if ($terms && !is_wp_error($terms)) :
                            $first_term = $terms[0];
                            $category_output = $first_term->name;
                        else :
                            $category_output = 'カテゴリなし';
                        endif;
                        ?>
                        <p class="item-category"><?php echo esc_html($category_output); ?></p>

                        <!-- ACFタイトル -->
                        <?php if (get_field('post_title')) : ?>
                            <a href="<?php the_permalink(); ?>">TEST投稿：<?php the_field('post_title'); ?></a>
                        <?php endif; ?>

                        <hr>

                    </li>
                <?php endwhile; ?>
            </ul>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <p>お知らせはありません。</p>
        <?php endif; ?>
    </section>

    <!-- サイトバー設定 -->
    <section>
        <?php get_sidebar('news'); ?> <!-- sidebar-news.php を読み込む -->
    </section>

</div>

<!-- OBOGの皆さまへ -->
<h1>OBOGの皆さまへ</h1>
<section class="l-pagebanner">
    <div class="l-pagebanner-inner grid-container2">
        <figure class="grid-item">
            <img src="https://dummyimage.com/349x198/a4a4a4/fff.jpg" alt="" srcset="" class="is-wide">
            <figcaption>ご入稿について（会員限定）<br><span class="is-figspan">サイト内の「OBOG会だより」や「会員だより」でご紹介する原稿を募集しています。OBOG会の予定案内や開催後の楽しいレポートのほか、ぜひ皆さまの近況報告や随想などをご入稿ください。</span></figcaption>
        </figure>
        <figure class="grid-item">
            <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                <img src="https://dummyimage.com/349x198/a4a4a4/fff.jpg" alt="" srcset="" class="is-wide">
                <figcaption>弔事のご連絡について<br><span class="is-figspan">弔事のご連絡は、記入様式を印刷し、各項目にご記入のうえFAXでご連絡願います。なお、土日祝日は担当者不在につき、ご対応が遅れる場合もあることを、予めご了承願います。</span></figcaption>
            </a>
        </figure>

    </div>
</section>




<?php get_footer(); ?>