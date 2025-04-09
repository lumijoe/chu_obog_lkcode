<?php get_header(); ?>
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
            <li class="breadcrumb-item">お知らせ詳細</li>

        </ol>
    </nav>
</section>
<!-- titleview -->
<section class="l-titleview">
    <img src="https://dummyimage.com/1200x110/dde1e6/dde1e6.jpg" alt="">
    <div class="l-titleview-ttl">
        <p>お知らせ詳細ページ</p>
    </div>
</section>
<!-- 記事セクション -->
<section class="l-article">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article>
                <!-- ACFタイトル -->
                <h2><?php the_field('post_title'); ?></h2>
                <!-- ACF投稿日時 -->
                <p><?php echo get_the_date('Y年m月d日'); ?></p>
                <!-- ACF本文 -->
                <p><?php the_field('post_text'); ?></p>
                <!-- 画像 -->
                <!-- 画像 -->
                <?php if (get_field('post_image')) : ?>
                    <img src="<?php the_field('post_image'); ?>"
                        alt="ニュース画像"
                        width="300"
                        data-src="<?php the_field('post_image'); ?>"
                        decoding="async"
                        class="lazyloaded">
                <?php endif; ?>
                <!-- PDF -->
                <?php if (get_field('post_pdf') && get_field('post_pdf_title')) : ?>
                    <p class="pdf-title">
                        <a href="<?php the_field('post_pdf'); ?>" target="_blank" rel="noopener noreferrer">
                            <?php the_field('post_pdf_title'); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <!-- 外部リンク -->
                <?php if (get_field('post_url')) : ?>
                    <p class="post-url">
                        <a href="<?php the_field('post_url'); ?>" target="_blank" rel="noopener noreferrer">
                            <?php the_field('post_url'); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </article>

            <!-- 前後の記事ナビゲーション -->
            <nav>
                <p><?php previous_post_link('« %link'); ?></p>
                <p><a href="<?php echo get_post_type_archive_link('news'); ?>">一覧に戻る</a></p>
                <p><?php next_post_link('%link »'); ?></p>
            </nav>

        <?php endwhile;
    else : ?>
        <p>ニュースがありません。</p>
    <?php endif; ?>
</section>

<!-- サイトバー設定 -->
<?php get_sidebar('news'); ?> <!-- sidebar-news.php を読み込む -->

<?php get_footer(); ?>