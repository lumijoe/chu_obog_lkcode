<?php get_header(); ?>
<!-- <section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
            <?php
            $terms = get_the_terms(get_the_ID(), 'newscategory');
            if ($terms && !is_wp_error($terms)) :
                $first_term = $terms[0];
                $term_link = get_term_link($first_term);
            ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($first_term->name); ?></a>
                </li>
            <?php endif; ?>
            <li class="breadcrumb-item"><?php the_field('post_title'); ?></li>

        </ol>
    </nav>
</section> -->
<!-- titleview -->
<section class="l-titleview">
    <img src="<?php echo get_template_directory_uri(); ?>/images/common/img_page_news.png" alt="お知らせ画像">
    <div class="l-titleview-ttl">
        <p class="l-page-caption">
            <?php
            $title = get_field('post_title');
            echo mb_strimwidth($title, 0, 50, '…', 'UTF-8');
            ?>
        </p>
    </div>
</section>

<!-- 記事セクション -->
<div class="l-side-grid single-wrapper">
    <section class="l-article article-single-wrapper">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article>
                    <div class="date-category-wrapper">
                        <!-- ACF投稿日時 -->
                        <date class="post-date"><?php echo get_the_date('Y.m.d'); ?></date>
                        <!-- ACFカテゴリ -->
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
                    </div>
                    <!-- ACFタイトル -->
                    <h2><?php the_field('post_title'); ?></h2>

                    <hr>
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
                    <hr>
                </article>

                <!-- 前後の記事ナビゲーション -->
                <nav>
                    <p><?php previous_post_link('« %link'); ?></p>
                    <p><a href="<?php echo get_post_type_archive_link('news'); ?>">一覧へ戻る</a></p>
                    <p><?php next_post_link('%link »'); ?></p>
                </nav>

            <?php endwhile;
        else : ?>
            <p>お知らせはありません</p>
        <?php endif; ?>
    </section>

    <!-- サイトバー設定 -->
    <section>
        <?php get_sidebar('news'); ?> <!-- sidebar-news.php を読み込む -->
    </section>
</div>
<!-- OBOGの皆さまへ -->
<?php get_template_part('template-parts/obog-banner'); ?>

<?php get_footer(); ?>