<?php

/**
 * トップページ
 */
get_header();
?>
<!-- パンくずリスト　 -->
<section class="l-breadcrumb">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">TOP</a></li>
    </ol>
  </nav>
</section>

<!-- スライダー -->
<section id="home">
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_page_top.png" class="d-block w-100" alt="">
        <div class="carousel-caption d-none d-md-block">
          <p>中外炉OBOGクラブは
            中外炉工業株式会社を退職された
            OBOGの皆さまのためのコミュニティクラブです</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_page_top.png" class="d-block w-100" alt="">
        <div class="carousel-caption d-none d-md-block">
          <!-- <h5>2つ目のスライド</h5> -->
        </div>
      </div>
      <div class="carousel-item">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_page_top.png" class="d-block w-100" alt="">
        <div class="carousel-caption d-none d-md-block">
          <!-- <h5>3つ目のスライド</h5> -->
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

<!-- お知らせ新着 -->
<section class="l-news-latest">
  <div class="l-news-latest-wrapper">
    <h2>お知らせ新着</h2>
    <?php
    $args = array(
      'post_type'      => 'news',
      'posts_per_page' => 5,
      'post_status'    => 'publish',
    );

    $news_query = new WP_Query($args);

    if ($news_query->have_posts()) : ?>
      <ul>
        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
          <li>
            <!-- 日付 -->
            <date class="post-date"><?php echo get_the_date('Y.m.d'); ?></date>

            <!-- カテゴリ -->
            <?php
            $terms = get_the_terms(get_the_ID(), 'newscategory');
            if ($terms && !is_wp_error($terms)) :
              $term_names = array_map(function ($term) {
                return $term->name;
              }, $terms);
              $category_output = implode(', ', $term_names);
            else :
              $category_output = 'カテゴリなし';
            endif;
            ?>
            <p class="item-category"><?php echo esc_html($category_output); ?></p>

            <!-- タイトル（ACF post_title） -->
            <?php if (get_field('post_title')) : ?>
              <p><a href="<?php the_permalink(); ?>"><?php the_field('post_title'); ?></a></p>
            <?php else : ?>
              <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
            <?php endif; ?>
          </li>
        <?php endwhile; ?>
      </ul>
      <?php wp_reset_postdata(); ?>
    <?php else : ?>
      <p>お知らせはまだありません。</p>
    <?php endif; ?>
  </div>
  <button class="btn btn-primay add-icon"><a href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧へ</a></button>
</section>




<!-- 各ニュース -->
<section class="l-pagebanner">
  <div class="l-pagebanner-inner grid-container">
    <figure class="grid-item">
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_about.png" alt="" srcset="" class="is-wide img-wide">
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
<section class="l-pagebanner for-all">
  <h2 class="section-ttl">OBOGの皆さまへ</h2>
  <div class="l-pagebanner-inner grid-container2">
    <div class="grid-item">
      <a href="<?php echo home_url('/about#memberpost'); ?>">
        <div class="banner-white">
          <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_bgwhite.png" alt="" class="is-background">
          <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_blue.svg" alt="" class="is-fronticon">
        </div>
        <div class="is-row">
          <figcaption>
            <h3>ご入稿について（会員限定）</h3>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
      <p>サイト内の「OBOG会だより」や「会員だより」でご紹介する原稿を募集しています。OBOG会の予定案内や開催後の楽しいレポートのほか、ぜひ皆さまの近況報告や随想などをご入稿ください。</p>
    </div>
    <div class="grid-item">
      <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
        <div class="banner-white">
          <img src="<?php echo get_template_directory_uri(); ?>/images/home/img_home_bgwhite.png" alt="" class="is-background">
          <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_blue.svg" alt="" class="is-fronticon">
        </div>
        <div class="is-row">
          <figcaption>
            <h3>弔事のご連絡について</h3>
          </figcaption>
          <img src="<?php echo get_template_directory_uri(); ?>/images/common/icon_right_bgwhite.svg" alt="">
        </div>
      </a>
      <p>弔事のご連絡は、記入様式を印刷し、各項目にご記入のうえFAXでご連絡願います。なお、土日祝日は担当者不在につき、ご対応が遅れる場合もあることを、予めご了承願います。</p>
    </div>
  </div>
</section>

<?php get_footer(); ?>