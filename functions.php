<?php

/**
 * custom_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package custom_theme
 */

// 管理画面ロゴ設定 
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/images/logo.svg);
            margin:0!important;
            width:100%;
        }
        .login h1 a {
            background-size:100%!important;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');

// 投稿タイプ
function create_post_type_news() {
    register_post_type(
        'news',
        array(
            'labels' => array(
                'name'          => 'お知らせ',
                'singular_name' => 'お知らせ',
                'all_items'     => 'お知らせ一覧',
            ),
            'public'       => true,
            'has_archive'  => true, // アーカイブページを有効にする
            'menu_position' => 5,
            'menu_icon'    => 'dashicons-edit',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'rewrite'      => array('slug' => 'news'), // URLを '/news/' にする
        )
    );
}
add_action('init', 'create_post_type_news');
