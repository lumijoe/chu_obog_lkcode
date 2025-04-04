<?php get_header(); ?>

<h1>会員だより（<?php single_term_title(); ?>）のニュース一覧</h1>

<?php if (have_posts()) : ?>
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <p><?php the_category(', '); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>
    <?php the_posts_pagination(); ?>
<?php else : ?>
    <p>会員だよりの投稿はありません。</p>
<?php endif; ?>

<?php get_footer(); ?>