<!-- 通常投稿の場合<?php get_header(); ?>
<h1>お知らせ一覧のページです</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <p><?php the_excerpt(); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php the_posts_pagination(); ?>

<?php else : ?>
    <p>ニュースがありません。</p>
<?php endif; ?>

<?php get_footer(); ?> -->

## 固定ページテンプレート
<?php

/**
 * Template Name: page-news
 * Description: This is the template
 */

get_header();
?>

<!-- <?php
/*******************************************
 * archive
 *******************************************/
// テーマディレクトリ
$theme_url = get_template_directory_uri();
get_header();
?> -->
