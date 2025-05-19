## home.php
<!-- home.php -->
<!-- パンくずリスト　 -->
<section class="l-breadcrumb">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">TOP</a></li>
    </ol>
  </nav>
</section>

## archive-news.php
<!-- archive.php -->
<!-- パンくずリスト -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
        </ol>
    </nav>
</section>

## taxonomy-newscategory-allevent.php
<!-- taxonomy-newscategory-allevent.php -->
<!-- パンくずリスト -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">全体行事</li>
        </ol>
    </nav>
</section>

## taxonomy-newscategory-company.php
<!-- taxonomy-newscategory-company.php -->
<!-- パンくずリスト　 -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">会社だより</li>
        </ol>
    </nav>
</section>

## taxonomy-newscategory-member.php
<!-- taxonomy-newscategory-member.php -->
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

## taxonomy-newscategory-obog.php
<!-- taxonomy-newscategory-obog.php -->
<!-- パンくずリスト -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">OBOG会だより</li>
        </ol>
    </nav>
</section>


## taxonomy-newscategory.php
<!-- taxonomy-newscategory.php -->
<!-- パンくずリスト -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/news'); ?>">お知らせ一覧</a></li>
        </ol>
    </nav>
</section>


## page-about.php
<!-- page-about.php -->
<!-- パンくずリスト -->
<section class="l-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url('/'); ?>">TOP</a></li>
            <li class="breadcrumb-item"><a href="<?php echo home_url('/about'); ?>">OBOGクラブについて</a></li>
        </ol>
    </nav>
</section>


## single-news.php
<!-- single-news.php -->
<!-- パンくずリスト -->
<section class="l-breadcrumb">
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
</section>