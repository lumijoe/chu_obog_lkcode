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

// ビジュアルエディタの非表示設定
function remove_editor_from_custom_post_type() {
    remove_post_type_support('news', 'editor'); // 'news' カスタム投稿タイプの名前、その投稿の時は非表示
}
add_action('init', 'remove_editor_from_custom_post_type');

// 投稿で選択したフォームカテゴリ＝記事カテゴリとする設定
function set_category_based_on_acf_radio( $post_id ) {
    // 投稿タイプが「お知らせ」の場合のみ実行
    if ( get_post_type( $post_id ) != 'news' ) {
        return;
    }

    // ACFフィールドで選択されたラジオボタンの値を取得
    $selected_category = get_field('post_category', $post_id); // 'post_category' はあなたが作成したフィールド名に変更

    // ラジオボタンの選択肢に基づいてカテゴリIDを設定
    $category_id = 0; // 初期化
    switch ($selected_category) {
        case 'news_company':
            $category_id = get_cat_ID('会社だより');
            break;
        case 'news_allevent':
            $category_id = get_cat_ID('全体行事');
            break;
        case 'news_obog':
            $category_id = get_cat_ID('OBOG会だより');
            break;
        case 'news_member_shin':
            $category_id = get_cat_ID('会員だより（新入会員）');
            break;
        case 'news_member_fuhou':
            $category_id = get_cat_ID('会員だより（訃報）');
            break;
    }

    // カテゴリIDが正しく取得できた場合、カテゴリを投稿に設定
    if ($category_id) {
        // カテゴリを設定
        wp_set_post_categories($post_id, array($category_id), true);
        
        // デバッグ用：カテゴリIDを出力
        error_log('カテゴリID: ' . $category_id);
    } else {
        // エラーメッセージを出力（必要なら）
        error_log('カテゴリIDが設定できませんでした');
    }
}
add_action('save_post', 'set_category_based_on_acf_radio');
