<?php

/**
 * custom_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package custom_theme
 */

// ========================
// スタイル設定
// ========================
function custom_theme_enqueue_styles()
{
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/assets/sass/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/sass/style.css')
    );
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');


// ========================
// スクリプト設定
// ========================
function custom_theme_enqueue_scripts()
{
    wp_enqueue_script(
        // アラートテスト
        'home-js',
        get_template_directory_uri() . '/assets/js/home.js',
        array(),
        filemtime(get_template_directory() . '/assets/js/home.js'),
        true // footerでの読み込みtrue
    );

    wp_enqueue_script(
        // ログインテスト
        'login-js',
        get_template_directory_uri() . '/assets/js/login.js',
        array(),
        filemtime(get_template_directory() . '/assets/js/login.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts');


// ========================
// 管理画面：ロゴ設定
// ========================
function my_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/images/logo.svg);
            margin: 0 !important;
            width: 100%;
        }

        .login h1 a {
            background-size: 100% !important;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');


// ========================
// 管理画面：投稿タイプ
// ========================
function create_post_type_news()
{
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


// ========================
// 管理画面：投稿一覧にカテゴリ表示
// ========================
function add_custom_columns($columns)
{
    // カテゴリ列を追加
    $columns['category'] = 'カテゴリ'; // 'category' は表示する列のキー、'カテゴリ' は列のタイトル

    return $columns;
}
add_filter('manage_news_posts_columns', 'add_custom_columns');


// ========================
// 管理画面：投稿一覧のカテゴリ列にカテゴリ名を表示
// ========================
function show_custom_column_data($column, $post_id)
{
    if ($column == 'category') {
        // 投稿に関連するカテゴリを取得
        $terms = get_the_terms($post_id, 'newscategory');
        if ($terms && !is_wp_error($terms)) {
            $term_list = array();
            foreach ($terms as $term) {
                $term_list[] = $term->name; // カテゴリ名を取得
            }
            echo implode(', ', $term_list); // カテゴリ名をカンマ区切りで表示
        } else {
            echo 'カテゴリなし'; // カテゴリがない場合
        }
    }
}
add_action('manage_news_posts_custom_column', 'show_custom_column_data', 10, 2);


// ========================
// 管理画面：投稿一覧にカテゴリフィルタを追加
// ========================
function add_category_filter_to_posts()
{
    global $typenow;

    // 'news' カスタム投稿タイプの場合のみフィルタを表示
    if ($typenow == 'news') {
        // カテゴリの選択肢を取得
        $terms = get_terms(array(
            'taxonomy' => 'newscategory',
            'orderby' => 'name',
            'hide_empty' => false, // カテゴリが空でも表示
        ));

        if ($terms) {
            // フィルタのフォームを表示
            echo '<select name="newscategory_filter" id="newscategory_filter">';
            echo '<option value="">カテゴリで絞り込む</option>';
            foreach ($terms as $term) {
                echo '<option value="' . esc_attr($term->term_id) . '" ' . selected($_GET['newscategory_filter'], $term->term_id, false) . '>' . esc_html($term->name) . '</option>';
            }
            echo '</select>';
        }
    }
}
add_action('restrict_manage_posts', 'add_category_filter_to_posts');



// ========================
// 管理画面：投稿一覧のクエリに絞り込み条件を追加
// ========================
function filter_news_by_category($query)
{
    global $pagenow;

    // 'news' カスタム投稿タイプの場合
    if ($pagenow == 'edit.php' && isset($_GET['newscategory_filter']) && $_GET['newscategory_filter'] != '') {
        $query->query_vars['tax_query'] = array(
            array(
                'taxonomy' => 'newscategory',
                'field' => 'id',
                'terms' => $_GET['newscategory_filter'],
                'operator' => 'IN',
            ),
        );
    }
}
add_filter('pre_get_posts', 'filter_news_by_category');



// ========================
// ビジュアルエディタの非表示設定
// ========================
function remove_editor_from_custom_post_type()
{
    remove_post_type_support('news', 'editor'); // 'news' カスタム投稿タイプの名前、その投稿の時は非表示
}
add_action('init', 'remove_editor_from_custom_post_type');
// ビジュアルエディタテキストタブ背景色
function custom_admin_styles()
{
    echo '<style>
        /* テキストタブの背景を黒に変更 */
        .wp-editor-area {
            background-color: #353535 !important;
            color: #fff !important; /* テキスト色を白に変更 */
        }
        .wp-editor-tabs .wp-tab-active {
            background-color: #333 !important; /* アクティブタブの背景色 */
        }
    </style>';
}
add_action('admin_head', 'custom_admin_styles');
