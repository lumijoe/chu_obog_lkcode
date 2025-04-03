<!-- カスタム投稿の一覧 -->
<?php get_header(); ?>
<h1>ニュース一覧</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <!-- 投稿タイトル（ACFタイトル or 投稿タイトル）-->
                <a href="<?php the_permalink(); ?>">
                    テスト投稿：<?php echo get_field('post_title') ?: get_the_title(); ?>
                </a>
                
                <!-- 投稿日時（ACFではなくWP標準）-->
                <p><?php echo get_the_date('Y年m月d日'); ?></p>
                
                <!-- 本文（エスケープ回避）-->
                <p><?php echo get_field('post_text'); ?></p>
                
                <!-- 画像 -->
                <?php 
                $post_image = get_field('post_image'); 
                if ($post_image): 
                    $image_url = is_array($post_image) ? $post_image['url'] : $post_image;
                ?>
                    <img src="<?php echo esc_url($image_url); ?>" 
                         alt="ニュース画像" 
                         width="300" 
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
