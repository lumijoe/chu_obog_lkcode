<!-- 通常投稿の場合<?php get_header(); ?>
<h1>お知らせ一覧のページです</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <p><?php the_excerpt(); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php the_posts_pagination(); ?>

<?php else : ?>
    <p>ニュースがありません。</p>
<?php endif; ?>

<?php get_footer(); ?> -->

## 固定ページテンプレート

<?php

/**
 * Template Name: page-news
 * Description: This is the template
 */

get_header();
?>

<!-- <?php
/*******************************************
 * archive
 *******************************************/
// テーマディレクトリ
$theme_url = get_template_directory_uri();
get_header();
?> -->

## archive

<?php
/*******************************************
 * archive
 *******************************************/
// テーマディレクトリ
$theme_url = get_template_directory_uri();
get_header();
?>
 <!-- ヘッダ画像 -->
 <div class="main__headline main__container">
		<div class="main__headline--text">
			<h1 class="main__headline--title">
				<span class="sub">IR News</span>
				<span class="title">IRニュース（IR適時開示情報）</span>
			</h1>
		</div>
		<figure class="main__headline--image w-100">
			<img src="<?php echo $theme_url; ?>/images/ir/headline_pc.jpg" alt="">
		</figure>
	</div>
		
	<!-- パンくず -->
	<nav class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
		<div class="main__container">
			<div class="breadcrumbs__inner">
				<?php if(function_exists('bcn_display')){ bcn_display(); }?>
			</div>
		</div>
	</nav>

    <section class="main__block news__content">
    <div class="main__container news-col02">

      <!-- 一覧 -->
      <div class="news__contents">
        <div class="tags v2 is-border">
          <a href="<?php echo esc_url( home_url( '/ir/news' ) ); ?>" class="tag is-active">すべて</a>
          <?php
          $taxonomy = 'ir-news_category';
          $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false, // 空のタームも取得
          ]);

          if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
              echo '<a href="' . get_term_link($term->slug, $taxonomy) . '" class="tag">' . $term->name . '</a>';
            }
          }
          ?>
        </div>
        <div class="news__grid">
          <ul class="news__list">
            <?php
            if (have_posts()) :
            while (have_posts()) : the_post(); ?>
              <li class="news__list--item">
                <time datetime="<?php the_time('Y-m-d'); ?>" class="date"><?php the_time('Y.m.d'); ?></time>
                <?php
                $terms = get_the_terms($post->ID, $taxonomy);
                if (!empty($terms) && !is_wp_error($terms)) {
                  echo '<a href="' . get_term_link($terms[0]->slug, $taxonomy) . '" class="tag">' . $terms[0]->name . '</a>';
                } ?>
                <?php
                // 投稿から1週間以内の記事には「NEW」をつける
                $post_date = get_the_date('U');
                $one_week_ago = strtotime('-1 week');

                if ($post_date >= $one_week_ago) {
                  echo '<span class="tag_new">NEW</span>';
                }
                ?>

                <?php
                if(get_locale() == 'en_US') {
                  if(get_field('pdf_file_en')) {
                    $pdf_file = get_field('pdf_file_en');
                  } else {
                    $pdf_file = get_field('pdf_file');
                  }
                } else {
                  $pdf_file = get_field('pdf_file');
                }
                if( $pdf_file ) {
                  $permalink = $pdf_file['url'];
                  $file_info = '（PDF：' . size_format($pdf_file['filesize']) . '）';
                  $target = "_blank";
                } else {
                  $permalink = get_the_permalink();
                  $file_info = '';
                  $target = "_self";
                }
                ?>
                <a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" class="title"><?php the_title(); ?><?php echo $file_info; ?></a>
              </li>
            <?php endwhile; ?>
            <?php else : ?>
              <div class="no-result">
    							<p>記事がありません</p>
    						</div>
            <?php endif; ?>
          </ul>
        </div>
        <?php if (paginate_links()): ?>
          <nav class="pager">
            <div class="pager__archive">
              <div class="pager__archive--inner">
                <?php the_paginate(); ?>
              </div>
            </div>
          </nav>
        <?php endif ?>
      </div>

      <!-- アーカイブ -->
      <div class="news__archive">
        <div class="news__archive--title">
          <h2 class="heading__02 is-border">
            <span class="heading__02--main">アーカイブ</span>
          </h2>
        </div>
        <div class="news__archive--grid">
          <ul class="news__archive--list">
            <?php
            wp_get_archives( array(
              'post_type' => 'ir-news',
              'type' => 'monthly',
              'show_post_count' => true
            ));
            ?>
          </ul>
        </div>
      </div>
    </div>

  </section>
<?php get_footer(); ?>

## 関連リンク ACF

<p>関連リンク: <a href="<?php the_field('related_link'); ?>" target="_blank">詳細はこちら</a></p>

## ビジュアルエディタを非表示にする方法

function remove_editor_from_custom_post_type() {
remove_post_type_support('news', 'editor'); // 'news' はカスタム投稿タイプの名前
}
add_action('init', 'remove_editor_from_custom_post_type');

## taxonomy リライト設定？コードの場合（効いてなかった気がする）

// taxonomy アーカイブテンプレートの存在
function force_taxonomy_archive_template($template)
{
    if (is_tax('newscategory')) {
        $new_template = locate_template(array('taxonomy-newscategory-member.php', 'taxonomy-newscategory.php', 'taxonomy.php'));
        if (!empty($new_template)) {
return $new_template;
}
}
return $template;
}
add_filter('template_include', 'force_taxonomy_archive_template');

// taxonomy リライト設定
function custom_taxonomy_rewrite_rule()
{
// カスタムタクソノミーの URL 構造を変更したい場合に使う
add_rewrite_rule(
'^news/([^/]+)/?$',
        'index.php?newscategory=$matches[1]',
'top'
);
}
add_action('init', 'custom_taxonomy_rewrite_rule');

## リンク
href="<?php echo home_url('/news'); ?>">中外炉工業OBOGクラブ
 href="<?php echo get_post_type_archive_link('news'); ?>">
  href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" 