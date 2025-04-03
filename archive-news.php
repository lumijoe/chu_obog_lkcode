<!-- カスタム投稿の一覧 -->
<?php get_header(); ?>
<h1>ニュース一覧</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <p><?php the_excerpt(); ?></p>
                
                <!-- ACFのカスタムフィールドを表示 -->
                <p>日付: <?php the_field('news_date'); ?></p>
                <p>サブタイトル: <?php the_field('post_title'); ?></p>
                <p>本文: <?php the_field('post_text'); ?></p>
                <p>画像:</p>
                <img src="<?php the_field('post_image'); ?>" 
                    alt="ニュース画像" 
                    width="300" 
                    data-src="<?php the_field('post_image'); ?>" 
                    decoding="async" 
                    class="lazyloaded">
                <p>関連リンク: <a href="<?php the_field('related_link'); ?>" target="_blank">詳細はこちら</a></p>                                    
            </li>
        <?php endwhile; ?>
    </ul>

    <?php the_posts_pagination(); ?>

<?php else : ?>
    <p>ニュースがありません。</p>
<?php endif; ?>
<h1>以下はhtmlテスト</h1>
    <div>
        <p>お知らせ一覧ページです-page-news</p>
        <br>
        <h1>タイトルが入りますタイトルが入りますタイトルが入ります</h1>
        <p>日時</p>
        <hr>
        <p>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります<br>
        本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります<br>
        本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります<br>
        本文が入ります本文が入ります本文が入ります本文が入ります<br>本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります本文が入ります</p>
        <p>PDFなどのダウンロードコンテンツ</p>
        <div style="width:200px; height:160px; background-color:#454545;"><p>img</p></div>
        <div class="display:flex; justify-content:center;">
            <button type="button" class="">前へ</button>
            <button type="button" class="">一覧に戻る</button>
            <button type="button" class="">次へ</button>
        </div>
       
    </div>

<?php get_footer(); ?>
