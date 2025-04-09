<?php get_header(); ?>
<!-- パンくずリスト　 -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">会員だより</li>
        </ol>
    </nav>
</section>
<!-- titleview -->
<section class="l-titleview">
    <img src="https://dummyimage.com/1200x110/dde1e6/dde1e6.jpg" alt="">
    <div class="l-titleview-ttl">
        <p><?php single_term_title(); ?>ページ</p>
        <small>会員の入会情報や慶弔情報、近況報告、随想などを掲載しています</small>
    </div>
</section>

<!-- カテゴリタブ -->
<div class="l-category-tab">
    <button><a href="<?php echo home_url('/news'); ?>">すべて</a></button>
    <button><a href="<?php echo home_url('/newscategory/allevent/'); ?>">全体行事</a></button>
    <button><a href="<?php echo home_url('/newscategory/company/'); ?>">会社だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/obog/'); ?>">OBOG会だより</a></button>
    <button class="is-current"><a href="<?php echo home_url('/newscategory/member/'); ?>">会員だより</a></button>
</div>

<!-- 記事セクション -->
<section class="l-article">
    <?php
    // タクソノミーに関連する投稿があるかチェック
    if (have_posts()) : ?>
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
                    // 投稿が所属しているタクソノミー 'newscategory' のカテゴリを取得
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
                </li>
            <?php endwhile; ?>
        </ul>

        <!-- 投稿のページネーション -->
        <?php the_posts_pagination(); ?>

    <?php else : ?>
        <!-- 投稿がない場合のメッセージ -->
        <p>お知らせはありません。</p>
    <?php endif; ?>
</section>

<?php get_footer(); ?>