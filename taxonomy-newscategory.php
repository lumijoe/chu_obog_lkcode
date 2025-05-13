<!-- タクソノミー共通レイアウト -->
<?php get_header(); ?>
<!-- <section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
        </ol>
    </nav>
</section> -->
<!-- titleview -->
<section class="l-titleview">
    <img src="https://dummyimage.com/1200x110/dde1e6/dde1e6.jpg" alt="">
    <p><?php single_term_title(); ?></p>
    <!-- <small>ページの内容を説明しています</small> -->
</section>

<!-- カテゴリタブ -->
<div class="l-category-tab">
    <button><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></button>
    <button><a href="<?php echo home_url('/newscategory/allevent/'); ?>">全体行事</a></button>
    <button><a href="<?php echo home_url('/newscategory/company/'); ?>">会社だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/obog/'); ?>">OBOG会だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/member/'); ?>">会員だより</a></button>
</div>

<!-- サイドバー -->
<div class="l-side-grid">
    <!-- 記事セクション -->
    <section class="l-article">
        <?php
        // タクソノミーに関連する投稿があるかチェック
        if (have_posts()) : ?>
            <ul>
                <hr class="article-top-hr">
                <?php while (have_posts()) : the_post(); ?>
                    <li class="sp-article-wrapper">
                        <div class="sp-article">
                            <!-- ACF投稿日時 -->
                            <date><?php echo get_the_date('Y.m.d'); ?></date>

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
                        </div>
                        <!-- ACFタイトル -->
                        <?php if (get_field('post_title')) : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_field('post_title'); ?></a>
                        <?php endif; ?>

                    </li>
                    <hr>
                <?php endwhile; ?>
            </ul>

            <!-- 投稿のページネーション -->
            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <!-- 投稿がない場合のメッセージ -->
            <p>お知らせはありません。</p>
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