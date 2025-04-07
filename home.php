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
<section>
<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo get_template_directory_uri(); ?>/images/home/mv01.jpg" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
        <!-- <h5>1つ目のスライド</h5>
        <p>中外炉工業OBOGクラブは
            中外炉工業株式会社を退職された
            OBOGの皆さまのためのコミュニティクラブです</p> -->
      </div>
    </div>
    <div class="carousel-item">
      <img src="<?php echo get_template_directory_uri(); ?>/images/home/mv01.jpg" class="d-block w-100" alt="">
      <div class="carousel-caption d-none d-md-block">
        <!-- <h5>2つ目のスライド</h5> -->
      </div>
    </div>
    <div class="carousel-item">
      <img src="<?php echo get_template_directory_uri(); ?>/images/home/mv01.jpg" class="d-block w-100" alt="">
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


<h1>OBOGクラブ</h1>


<?php get_footer(); ?>