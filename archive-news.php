<!-- カスタム投稿の一覧 -->
<?php get_header(); ?>
<h1>ニュース一覧</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <!-- ACFタイトル -->
                <a href="<?php the_permalink(); ?>"><?php the_field('post_title'); ?></a>
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
            </li>
        <?php endwhile; ?>
    </ul>

    <?php the_posts_pagination(); ?>

<?php else : ?>
    <p>ニュースがありません。</p>
<?php endif; ?>


<?php get_footer(); ?>
