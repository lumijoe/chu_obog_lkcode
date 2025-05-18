<!-- 404.php -->
<?php get_header(); ?>
<div id="404-page">
    <h2>404 Not Found（ページが見つかりませんでした）</h2>
    <p>お探しのページは存在しないか、または移動した可能性があります。</p>
    <button class="btn btn-primay add-icon"><a href="<?php echo home_url('/'); ?>">トップへ戻る</a></button>
</div>
<?php
get_footer();
