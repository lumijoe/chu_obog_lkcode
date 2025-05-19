<?php

/**
 * トップページ
 */
get_header();
?>

<!-- ヒーロー -->
<section id="home">
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="z-index:2000;">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_page_top.png" class="d-block w-100" alt="">
        <div class="carousel-caption d-md-block hero-carousel">
          <p>中外炉OBOGクラブは、<br class="sp-605 d-none">中外炉工業株式会社を退職された<br>
            OBOGの皆さまのための<br class="sp-605 d-none">コミュニティクラブです</p>
        </div>
      </div>
    </div>
</section>

<!--ログインフォーム  -->
<div id="overlay"></div>
<div id="login-form">
  <button class="close-btn" id="close-btn">✕</button>
  <h2>ログイン</h2>
  <form>
    <label>ユーザー名：<br /><input type="text" id="username" name="username" placeholder="ユーザー名" required /></label><br /><br />
    <label>パスワード：<br /><input type="password" id="password" name="password" placeholder="パスワード" required /></label><br /><br />
    <button type="submit">ログイン</button>
  </form>
</div>

<!-- お知らせ新着 -->
<section class="l-news-latest l-article">
  <div class="l-news-latest-wrapper">
    <h2>お知らせ 新着</h2>
    <?php
    $args = array(
      'post_type'      => 'news',
      'posts_per_page' => 4,
      'post_status'    => 'publish',
    );

    $news_query = new WP_Query($args);

    if ($news_query->have_posts()) : ?>
      <ul>
        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
          <li class="sp-article-wrapper">
            <div class="sp-article">
              <!-- 日付 -->
              <date class="post-date"><?php echo get_the_date('Y.m.d'); ?></date>

              <!-- カテゴリ -->
              <?php
              $terms = get_the_terms(get_the_ID(), 'newscategory');
              if ($terms && !is_wp_error($terms)) :
                $first_term = $terms[0];
                $category_output = $first_term->name;
              else :
                $category_output = 'カテゴリなし';
              endif;
              ?>
              <!-- span新着タグ -->
              <?php
              // 投稿日と現在の日付を取得
              $post_date = get_the_date('Y-m-d');
              $post_datetime = new DateTime($post_date);
              $now = new DateTime();

              // 投稿が過去の日付かチェック（未来記事を除外）
              if ($post_datetime <= $now) {
                $interval = $now->diff($post_datetime)->days;

                // 7日以内ならNEWを表示
                if ($interval < 7) :
              ?>
                  <span class="tag_new">NEW</span>
              <?php
                endif;
              }
              ?>
              <p class="item-category"><?php echo esc_html($category_output); ?></p>
            </div>
            <!-- タイトル（ACF post_title） -->
            <?php if (get_field('post_title')) : ?>
              <p><a href="<?php the_permalink(); ?>"><?php the_field('post_title'); ?></a></p>
            <?php else : ?>
              <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
            <?php endif; ?>
          </li>
          <hr>
        <?php endwhile; ?>
      </ul>
      <?php wp_reset_postdata(); ?>
    <?php else : ?>
      <p>お知らせはまだありません。</p>
    <?php endif; ?>
  </div>
  <button class="btn btn-primay add-icon"><a href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧へ</a></button>
</section>

<!-- ページバナー -->
<section class="l-pagebanner">
  <div class="l-pagebanner-inner grid-container">
    <figure class="grid-item">
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_about.png" alt="" srcset="" class="is-wide img-wide max538-none">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_about_sp.png" alt="" srcset="" class="is-wide img-tight d-none max538-display">
        <div class="is-row">
          <figcaption>
            <h2>中外炉OBOGクラブについて</h2>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
    </figure>
  </div>
  <div class="l-pagebanner-inner grid-container2">
    <figure class="grid-item">
      <a href="<?php echo home_url('/newscategory/allevent'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_allevent.png" alt="" srcset="" class="is-wide img-tight">
        <div class="is-row">
          <figcaption>
            <h2>全体行事</h2>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
    </figure>
    <figure class="grid-item">
      <a href="<?php echo home_url('/newscategory/company'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_company.png" alt="" srcset="" class="is-wide img-tight">
        <div class="is-row">
          <figcaption>
            <h2>会社だより</h2>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
    </figure>
    <figure class="grid-item">
      <a href="<?php echo home_url('/newscategory/obog'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_obog.png" alt="" srcset="" class="is-wide img-tight">
        <div class="is-row">
          <figcaption>
            <h2>OBOGだより</h2>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
    </figure>
    <figure class="grid-item">
      <a href="<?php echo home_url('/newscategory/member'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_member.png" alt="" srcset="" class="is-wide img-tight">
        <div class="is-row">
          <figcaption>
            <h2>会員だより</h2>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
    </figure>
  </div>
</section>

<!-- OBOGの皆さまへ -->
<?php get_template_part('template-parts/obog-banner'); ?>
<!-- フッター -->
<?php get_footer(); ?>