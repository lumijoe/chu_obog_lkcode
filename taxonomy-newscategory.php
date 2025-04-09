<!-- タクソノミー共通レイアウト -->
<?php get_header(); ?>
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
        </ol>
    </nav>
</section>
<!-- titleview -->
<section class="l-titleview">
    <img src="https://dummyimage.com/1200x110/dde1e6/dde1e6.jpg" alt="">
    <p><?php single_term_title(); ?>ページ</p>
    <!-- <small>ページの内容を説明しています</small> -->
</section>

<!-- カテゴリタブ -->
<div class="l-category-tab">
    <button><a href="<?php echo home_url('/news'); ?>">すべて</a></button>
    <button><a href="<?php echo home_url('/newscategory/allevent/'); ?>">全体行事</a></button>
    <button><a href="<?php echo home_url('/newscategory/company/'); ?>">会社だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/obog/'); ?>">OBOG会だより</a></button>
    <button><a href="<?php echo home_url('/newscategory/member/'); ?>">会員だより</a></button>
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


<!-- OBOGの皆さまへ -->
<h1>OBOGの皆さまへ</h1>
<section class="l-pagebanner">
  <div class="l-pagebanner-inner grid-container2">
    <figure class="grid-item">
      <img src="https://dummyimage.com/349x198/a4a4a4/fff.jpg" alt="" srcset="" class="is-wide">
      <figcaption>ご入稿について（会員限定）<br><span class="is-figspan">サイト内の「OBOG会だより」や「会員だより」でご紹介する原稿を募集しています。OBOG会の予定案内や開催後の楽しいレポートのほか、ぜひ皆さまの近況報告や随想などをご入稿ください。</span></figcaption>
    </figure>
    <figure class="grid-item">
      <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
        <img src="https://dummyimage.com/349x198/a4a4a4/fff.jpg" alt="" srcset="" class="is-wide">
        <figcaption>弔事のご連絡について<br><span class="is-figspan">弔事のご連絡は、記入様式を印刷し、各項目にご記入のうえFAXでご連絡願います。なお、土日祝日は担当者不在につき、ご対応が遅れる場合もあることを、予めご了承願います。</span></figcaption>
      </a>
    </figure>

  </div>
</section>
<?php get_footer(); ?>