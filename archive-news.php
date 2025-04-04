<!-- カスタム投稿の一覧 -->
<?php get_header(); ?>
<h1>ニュース一覧</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <!-- ACFタイトル -->
                <?php if (get_field('post_title')) : ?>
                    <a href="<?php the_permalink(); ?>">TEST投稿：<?php the_field('post_title'); ?></a>
                <?php endif; ?>

                <!-- ACF投稿日時 -->
                <p><?php echo get_the_date('Y年m月d日'); ?></p>

                <!-- カテゴリ表示 -->
                <?php
                $terms = get_the_terms(get_the_ID(), 'newscategory');
                if ($terms && !is_wp_error($terms)) : ?>
                    <p class="post-category">
                        <?php
                        $term_list = array();
                        foreach ($terms as $term) {
                            $term_list[] = $term->name; // カテゴリ名を取得
                        }
                        echo implode(', ', $term_list); // 複数カテゴリがあればカンマ区切りで表示
                        ?>
                    </p>
                <?php endif; ?>

                <!-- ACF本文 -->
                <?php if (get_field('post_text')) : ?>
                    <p><?php the_field('post_text'); ?></p>
                <?php endif; ?>

                <!-- 画像 -->
                <?php if (get_field('post_image')) : ?>
                    <img src="<?php the_field('post_image'); ?>"
                        alt="ニュース画像"
                        width="300"
                        data-src="<?php the_field('post_image'); ?>"
                        decoding="async"
                        class="lazyloaded">
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php the_posts_pagination(); ?>

<?php else : ?>
    <p>お知らせはありません。</p>
<?php endif; ?>


<?php get_footer(); ?>