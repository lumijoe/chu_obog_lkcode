<?php get_header(); ?>

<h1>ニュース詳細</h1>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article>
        <!-- ACFタイトル -->
        <h2><?php the_field('post_title'); ?></h2>
        <!-- ACF投稿日時 -->
        <p><?php echo get_the_date('Y年m月d日'); ?></p>
        <!-- ACF本文 -->
        <p><?php the_field('post_text'); ?></p>
        <!-- 画像 -->
        <img src="<?php the_field('post_image'); ?>" 
            alt="ニュース画像" 
            width="300" 
            data-src="<?php the_field('post_image'); ?>" 
            decoding="async" 
            class="lazyloaded">
    </article>

    <!-- 前後の記事ナビゲーション -->
    <nav>
        <p><?php previous_post_link('« %link'); ?></p>
        <p><a href="<?php echo get_post_type_archive_link('news'); ?>">一覧に戻る</a></p>
        <p><?php next_post_link('%link »'); ?></p>
    </nav>

<?php endwhile; else : ?>
    <p>ニュースがありません。</p>
<?php endif; ?>

<!-- サイトバー設定 -->
<?php get_sidebar('news'); ?> <!-- sidebar-news.php を読み込む -->

<?php get_footer(); ?>
