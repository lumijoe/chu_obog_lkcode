<!-- カスタム投稿の一覧 -->
<?php get_header(); ?>
<h1>ニュース一覧</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <!-- ACFタイトル -->
                <a href="<?php the_permalink(); ?>">テスト投稿：<?php the_field('post_title'); ?></a>
                <!-- ACF投稿日時 -->
                <p><?php echo get_the_date('Y年m月d日'); ?></p>
                <!-- カテゴリ表示 -->
                <!-- カテゴリスラッグ表示 -->
                <p class="post-category">
                    <?php
                    // 投稿に関連するカテゴリ（newscategory）を表示
                    $terms = get_the_terms(get_the_ID(), 'newscategory');
                    if ($terms && !is_wp_error($terms)) {
                        $term_list = array();
                        foreach ($terms as $term) {
                            $term_list[] = $term->name; // カテゴリ名を取得
                        }
                        echo implode(', ', $term_list); // 複数カテゴリがあればカンマ区切りで表示
                    }
                    ?>
                </p>
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
