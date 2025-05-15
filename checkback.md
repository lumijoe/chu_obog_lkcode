## さらにheader.phpだけでなく、functions.phpも変更もらった
これも、logoutでなくoboglogoutの箇所が必要だった
- ## mr.t
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


// ========================
// 認証：.env を読み込む関数、環境変数
// ========================
function load_env()
{
    $env_path = ABSPATH . '.env'; // public/.env のパス（ABSPATH は WordPressルートのパス）
    if (file_exists($env_path)) {
        $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }
}
add_action('init', 'load_env');


// ========================
// 認証：セッションスタート（必須）
// ========================
function start_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);


// ========================
// 認証：ログインチェック（Ajax）
// ========================
function handle_login_check()
{
    $username = $_ENV['CROBC_USERNAME'] ?? '';
    $password = $_ENV['CROBC_PASSWORD'] ?? '';

    $input_username = sanitize_text_field($_POST['username'] ?? '');
    $input_password = sanitize_text_field($_POST['password'] ?? '');

    if ($input_username === $username && $input_password === $password) {
        // セッションにログイン状態を保存
        $_SESSION['logged_in'] = true;
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }

    wp_die();
}
add_action('wp_ajax_login_check', 'handle_login_check');
add_action('wp_ajax_nopriv_login_check', 'handle_login_check');


// ========================
// 認証：ログイン状態確認関数（テンプレートなどで使う用）
// ========================
function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function restrict_pages_if_not_logged_in()
{
    if (
        !is_logged_in() &&                         // ログインしていない
        !is_front_page() &&                        // トップページではない
        !is_admin() &&                             // 管理画面ではない
        !defined('DOING_AJAX')                     // AJAX通信中ではない
    ) {
        wp_redirect(home_url());                  // トップにリダイレクト
        exit;
    }
}
add_action('template_redirect', 'restrict_pages_if_not_logged_in');


// ========================
// 認証：ログアウト処理（GETでログアウト）
// ========================
function handle_custom_logout()
{
    if (isset($_GET['action']) && $_GET['action'] === 'oboglogout') {
        $_SESSION['logged_in'] = false;
        wp_redirect(home_url('/'));
        exit;
    }
}
add_action('init', 'handle_custom_logout');
- ## mine
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


// ========================
// 認証：.env を読み込む関数、環境変数
// ========================
function load_env()
{
    $env_path = ABSPATH . '.env'; // public/.env のパス（ABSPATH は WordPressルートのパス）
    if (file_exists($env_path)) {
        $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }
}
add_action('init', 'load_env');


// ========================
// 認証：セッションスタート（必須）
// ========================
function start_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);


// ========================
// 認証：ログインチェック（Ajax）
// ========================
function handle_login_check()
{
    $username = $_ENV['CROBC_USERNAME'] ?? '';
    $password = $_ENV['CROBC_PASSWORD'] ?? '';

    $input_username = sanitize_text_field($_POST['username'] ?? '');
    $input_password = sanitize_text_field($_POST['password'] ?? '');

    if ($input_username === $username && $input_password === $password) {
        // セッションにログイン状態を保存
        $_SESSION['logged_in'] = true;
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }

    wp_die();
}
add_action('wp_ajax_login_check', 'handle_login_check');
add_action('wp_ajax_nopriv_login_check', 'handle_login_check');


// ========================
// 認証：ログイン状態確認関数（テンプレートなどで使う用）
// ========================
function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function restrict_pages_if_not_logged_in()
{
    if (
        !is_logged_in() &&                         // ログインしていない
        !is_front_page() &&                        // トップページではない
        !is_admin() &&                             // 管理画面ではない
        !defined('DOING_AJAX')                     // AJAX通信中ではない
    ) {
        wp_redirect(home_url());                  // トップにリダイレクト
        exit;
    }
}
add_action('template_redirect', 'restrict_pages_if_not_logged_in');


// ========================
// 認証：ログアウト処理（GETでログアウト）
// ========================
function handle_custom_logout()
{
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        $_SESSION['logged_in'] = false;
        wp_redirect(home_url('/'));
        exit;
    }
}
add_action('init', 'handle_custom_logout');








## header.php_v20515_１137_モーダルのバグ修正OK、管理画面ログアウトもOK
/?action=logoutではなく、oboglogoutだった。
- ## mr.t
<?php

/**
 * ヘッダー
 */
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="description" content="中外炉工業株式会社の退職者コミュニティーです">
    <title>中外炉工業OBOGクラブ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- OGP Meta　Tags -->
    <meta property="og:title" content="中外炉工業OBOGクラブ">
    <meta property="og:description" content="中外炉工業株式会社を退職されたOBOGの皆さまのためのコミュニティークラブです。所定の基準を満たす中外炉OBOGの皆さまなら、だれでも入会できるメンバーズクラブです。">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/ogp.png">
    <meta property="og:url" content="<?php echo home_url('/'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="中外炉工業OBOGクラブ">
    <?php wp_head(); ?>
</head>

<style>
    .btn-login {
        display: none !important;
    }
</style>

<body <?php body_class(); ?>>
    <?php if (!is_logged_in()) : ?>
        <?php get_template_part('template-parts/modal-login'); ?>
    <?php endif; ?>
    <header id="header" class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <h1><a class="navbar-brand" href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/home/logo.png" alt="" width="199" height="52" style="max-width:100%;"><span class="top-ttl">中外炉OBOGクラブ</span></a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- sp only -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/allevent'); ?>">全体行事</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/company'); ?>">会社だより</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/obog'); ?>">OBOG会だより</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/member'); ?>">会員だより</a>
                        </li>
                        <hr>
                    </ul>
                    <ul class="d-lg-none nav-only-cta">
                        <li>
                            <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_white.png " alt="" width="45" height="42" style="max-width:100%;">
                                弔事の<br>ご連絡について
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/about#memberpost'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_white.png " alt="" width="45" height="42" style="max-width:100%;">
                                ご入稿について<br>（会員限定）
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContentPC">
                    <button class="btn" type="submit">
                        <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_white.png " alt="" width="45" height="42" style="max-width:100%;">
                            <br>弔事の<br>ご連絡について
                        </a>
                    </button>
                    <button class="btn" type="submit">
                        <img>
                        <a href="<?php echo home_url('/about#memberpost'); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_white.png " alt="" width="45" height="42" style="max-width:100%;">
                            <br>ご入稿について<br>（会員限定）
                        </a>
                    </button>
                </div>
            </div>
        </nav>
        <!-- ログインボタン -->
        <button type="button" class="btn btn-primary btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
            ログイン
        </button>
        <!-- ログインモーダル -->
        <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">会員専用ページ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body modal-login">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">ユーザー名</label>
                                <input type="text" class="form-control" id="username" placeholder="ユーザー名を入力">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="password" placeholder="パスワードを入力">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="logincheck">
                                <label class="form-check-label" for="logincheck">ログイン状態を保持する</label>
                            </div>
                            <button type="submit" class="btn btn-primary">ログインする</button>
                        </form>
                        <div id="error-message" class="text-danger mt-2" style="display: none;">
                            ユーザー名またはパスワードが間違っています。
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (is_logged_in()) : ?>
            <p style="color: green;">ログイン中です | <a href="<?php echo home_url('/?action=oboglogout'); ?>">ログアウト</a></p>
        <?php else : ?>
            <p style="color: red;">ログアウト状態です</p>
        <?php endif; ?>

        <script>
            // ハンバーガーナビパネル 
            document.addEventListener("DOMContentLoaded", function() {
                const navbarCollapse = document.getElementById("navbarSupportedContent");
                const navbar = document.querySelector(".navbar");
                const toggler = document.querySelector(".navbar-toggler");

                if (navbarCollapse && navbar && toggler) {
                    // 開く
                    navbarCollapse.addEventListener("show.bs.collapse", function() {
                        navbar.classList.add("is-open");
                        document.body.classList.add("no-scroll");
                    });

                    // 閉じる
                    navbarCollapse.addEventListener("hide.bs.collapse", function() {
                        navbar.classList.remove("is-open");
                        document.body.classList.remove("no-scroll");
                    });
                }
            });
        </script>

        <script>
            // フォーム送信時にAJAXでログイン処理をサーバーにリクエスト
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();

                 const usernameInput = document.getElementById('username').value;
                 const passwordInput = document.getElementById('password').value;

                 const data = {
                     action: 'login_check',
                     username: usernameInput,
                     password: passwordInput
                 };

                jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                    if (response.success) {
                        alert('ログイン成功');

                        // Bootstrap 5 モーダルを閉じる方法
                        const modalEl = document.getElementById('loginModal');
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        modal.hide();
                        document.removeEventListener('click', click_obog_doc);
                    } else {
                        document.getElementById('error-message').style.display = 'block';
                    }
                });
            });
        </script>

		<?php if(!is_logged_in()) {?>
        <script>
            /*document.addEventListener('click', function(event) {
                // 1. ログイン済みユーザーは何もしない（WP の body_class() で 'logged-in' が付くので利用）
                if (document.body.classList.contains('logged-in')) return;

                // 2. 既にモーダル内をクリックした場合はスキップ
                if (event.target.closest('#loginModal .modal-content')) return;

                // 3. クリックされたのが送信ボタン（ログインボタン）の場合、何もしない
                if (event.target.closest('.btn-login')) return;

                // クリックされたらフォーム表示
                const modalEl = document.getElementById('loginModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });*/
            document.addEventListener('click', click_obog_doc);
            function click_obog_doc(event) {
                // 1. ログイン済みユーザーは何もしない（WP の body_class() で 'logged-in' が付くので利用）
                if (document.body.classList.contains('logged-in')) return;

                // 2. 既にモーダル内をクリックした場合はスキップ
                if (event.target.closest('#loginModal .modal-content')) return;

                // 3. クリックされたのが送信ボタン（ログインボタン）の場合、何もしない
                if (event.target.closest('.btn-login')) return;

                // クリックされたらフォーム表示
                const modalEl = document.getElementById('loginModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        </script>
        <?php } ?>
    </header>
    <main class="main">









## header.php_v10515_１０００_モーダルのバグ修正OK、管理画面ログアウトが未修正
- ## mr.t
<?php

/**
 * ヘッダー
 */
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="description" content="中外炉工業株式会社の退職者コミュニティーです">
    <title>中外炉工業OBOGクラブ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- OGP Meta　Tags -->
    <meta property="og:title" content="中外炉工業OBOGクラブ">
    <meta property="og:description" content="中外炉工業株式会社を退職されたOBOGの皆さまのためのコミュニティークラブです。所定の基準を満たす中外炉OBOGの皆さまなら、だれでも入会できるメンバーズクラブです。">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/ogp.png">
    <meta property="og:url" content="<?php echo home_url('/'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="中外炉工業OBOGクラブ">
    <?php wp_head(); ?>
</head>

<style>
    .btn-login {
        display: none !important;
    }
</style>

<body <?php body_class(); ?>>
    <?php if (!is_logged_in()) : ?>
        <?php get_template_part('template-parts/modal-login'); ?>
    <?php endif; ?>
    <header id="header" class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <h1><a class="navbar-brand" href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/home/logo.png" alt="" width="199" height="52" style="max-width:100%;"><span class="top-ttl">中外炉OBOGクラブ</span></a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- sp only -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/allevent'); ?>">全体行事</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/company'); ?>">会社だより</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/obog'); ?>">OBOG会だより</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/member'); ?>">会員だより</a>
                        </li>
                        <hr>
                    </ul>
                    <ul class="d-lg-none nav-only-cta">
                        <li>
                            <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_white.png " alt="" width="45" height="42" style="max-width:100%;">
                                弔事の<br>ご連絡について
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/about#memberpost'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_white.png " alt="" width="45" height="42" style="max-width:100%;">
                                ご入稿について<br>（会員限定）
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContentPC">
                    <button class="btn" type="submit">
                        <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_white.png " alt="" width="45" height="42" style="max-width:100%;">
                            <br>弔事の<br>ご連絡について
                        </a>
                    </button>
                    <button class="btn" type="submit">
                        <img>
                        <a href="<?php echo home_url('/about#memberpost'); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_white.png " alt="" width="45" height="42" style="max-width:100%;">
                            <br>ご入稿について<br>（会員限定）
                        </a>
                    </button>
                </div>
            </div>
        </nav>
        <!-- ログインボタン -->
        <button type="button" class="btn btn-primary btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
            ログイン
        </button>
        <!-- ログインモーダル -->
        <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">会員専用ページ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body modal-login">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">ユーザー名</label>
                                <input type="text" class="form-control" id="username" placeholder="ユーザー名を入力">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="password" placeholder="パスワードを入力">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="logincheck">
                                <label class="form-check-label" for="logincheck">ログイン状態を保持する</label>
                            </div>
                            <button type="submit" class="btn btn-primary">ログインする</button>
                        </form>
                        <div id="error-message" class="text-danger mt-2" style="display: none;">
                            ユーザー名またはパスワードが間違っています。
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (is_logged_in()) : ?>
            <p style="color: green;">ログイン中です | <a href="<?php echo home_url('/?action=logout'); ?>">ログアウト</a></p>
        <?php else : ?>
            <p style="color: red;">ログアウト状態です</p>
        <?php endif; ?>

        <script>
            // ハンバーガーナビパネル 
            document.addEventListener("DOMContentLoaded", function() {
                const navbarCollapse = document.getElementById("navbarSupportedContent");
                const navbar = document.querySelector(".navbar");
                const toggler = document.querySelector(".navbar-toggler");

                if (navbarCollapse && navbar && toggler) {
                    // 開く
                    navbarCollapse.addEventListener("show.bs.collapse", function() {
                        navbar.classList.add("is-open");
                        document.body.classList.add("no-scroll");
                    });

                    // 閉じる
                    navbarCollapse.addEventListener("hide.bs.collapse", function() {
                        navbar.classList.remove("is-open");
                        document.body.classList.remove("no-scroll");
                    });
                }
            });
        </script>

        <script>
            // フォーム送信時にAJAXでログイン処理をサーバーにリクエスト
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();

                 const usernameInput = document.getElementById('username').value;
                 const passwordInput = document.getElementById('password').value;

                 const data = {
                     action: 'login_check',
                     username: usernameInput,
                     password: passwordInput
                 };

                jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                    if (response.success) {
                        alert('ログイン成功');

                        // Bootstrap 5 モーダルを閉じる方法
                        const modalEl = document.getElementById('loginModal');
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        modal.hide();
                        document.removeEventListener('click', click_obog_doc);
                    } else {
                        document.getElementById('error-message').style.display = 'block';
                    }
                });
            });
        </script>

		<?php if(!is_logged_in()) {?>
        <script>
            /*document.addEventListener('click', function(event) {
                // 1. ログイン済みユーザーは何もしない（WP の body_class() で 'logged-in' が付くので利用）
                if (document.body.classList.contains('logged-in')) return;

                // 2. 既にモーダル内をクリックした場合はスキップ
                if (event.target.closest('#loginModal .modal-content')) return;

                // 3. クリックされたのが送信ボタン（ログインボタン）の場合、何もしない
                if (event.target.closest('.btn-login')) return;

                // クリックされたらフォーム表示
                const modalEl = document.getElementById('loginModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });*/
            document.addEventListener('click', click_obog_doc);
            function click_obog_doc(event) {
                // 1. ログイン済みユーザーは何もしない（WP の body_class() で 'logged-in' が付くので利用）
                if (document.body.classList.contains('logged-in')) return;

                // 2. 既にモーダル内をクリックした場合はスキップ
                if (event.target.closest('#loginModal .modal-content')) return;

                // 3. クリックされたのが送信ボタン（ログインボタン）の場合、何もしない
                if (event.target.closest('.btn-login')) return;

                // クリックされたらフォーム表示
                const modalEl = document.getElementById('loginModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        </script>
        <?php } ?>
    </header>
    <main class="main">

- ## me
<?php

/**
 * ヘッダー
 */
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="description" content="中外炉工業株式会社の退職者コミュニティーです">
    <title>中外炉工業OBOGクラブ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- OGP Meta　Tags -->
    <meta property="og:title" content="中外炉工業OBOGクラブ">
    <meta property="og:description" content="中外炉工業株式会社を退職されたOBOGの皆さまのためのコミュニティークラブです。所定の基準を満たす中外炉OBOGの皆さまなら、だれでも入会できるメンバーズクラブです。">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/ogp.png">
    <meta property="og:url" content="<?php echo home_url('/'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="中外炉工業OBOGクラブ">
    <?php wp_head(); ?>
</head>

<style>
    .btn-login {
        display: none !important;
    }
</style>

<body <?php body_class(); ?>>
    <?php if (!is_logged_in()) : ?>
        <?php get_template_part('template-parts/modal-login'); ?>
    <?php endif; ?>
    <header id="header" class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <h1><a class="navbar-brand" href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/home/logo.png" alt="" width="199" height="52" style="max-width:100%;"><span class="top-ttl">中外炉OBOGクラブ</span></a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- sp only -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/allevent'); ?>">全体行事</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/company'); ?>">会社だより</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/obog'); ?>">OBOG会だより</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/member'); ?>">会員だより</a>
                        </li>
                        <hr>
                    </ul>
                    <ul class="d-lg-none nav-only-cta">
                        <li>
                            <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_white.png " alt="" width="45" height="42" style="max-width:100%;">
                                弔事の<br>ご連絡について
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/about#memberpost'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_white.png " alt="" width="45" height="42" style="max-width:100%;">
                                ご入稿について<br>（会員限定）
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContentPC">
                    <button class="btn" type="submit">
                        <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_mail_white.png " alt="" width="45" height="42" style="max-width:100%;">
                            <br>弔事の<br>ご連絡について
                        </a>
                    </button>
                    <button class="btn" type="submit">
                        <img>
                        <a href="<?php echo home_url('/about#memberpost'); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/home/icon_note_white.png " alt="" width="45" height="42" style="max-width:100%;">
                            <br>ご入稿について<br>（会員限定）
                        </a>
                    </button>
                </div>
            </div>
        </nav>
        <!-- ログインボタン -->
        <button type="button" class="btn btn-primary btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
            ログイン
        </button>
        <!-- ログインモーダル -->
        <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">会員専用ページ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body modal-login">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">ユーザー名</label>
                                <input type="text" class="form-control" id="username" placeholder="ユーザー名を入力">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="password" placeholder="パスワードを入力">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="logincheck">
                                <label class="form-check-label" for="logincheck">ログイン状態を保持する</label>
                            </div>
                            <button type="submit" class="btn btn-primary">ログインする</button>
                        </form>
                        <div id="error-message" class="text-danger mt-2" style="display: none;">
                            ユーザー名またはパスワードが間違っています。
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (is_logged_in()) : ?>
            <p style="color: green;">ログイン中です | <a href="<?php echo home_url('/?action=logout'); ?>">ログアウト</a></p>
        <?php else : ?>
            <p style="color: red;">ログアウト状態です</p>
        <?php endif; ?>

        <script>
            // ハンバーガーナビパネル 
            document.addEventListener("DOMContentLoaded", function() {
                const navbarCollapse = document.getElementById("navbarSupportedContent");
                const navbar = document.querySelector(".navbar");
                const toggler = document.querySelector(".navbar-toggler");

                if (navbarCollapse && navbar && toggler) {
                    // 開く
                    navbarCollapse.addEventListener("show.bs.collapse", function() {
                        navbar.classList.add("is-open");
                        document.body.classList.add("no-scroll");
                    });

                    // 閉じる
                    navbarCollapse.addEventListener("hide.bs.collapse", function() {
                        navbar.classList.remove("is-open");
                        document.body.classList.remove("no-scroll");
                    });
                }
            });
        </script>

        <script>
            // フォーム送信時にAJAXでログイン処理をサーバーにリクエスト
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();

                // const usernameInput = document.getElementById('username').value;
                // const passwordInput = document.getElementById('password').value;

                // const data = {
                //     action: 'login_check',
                //     username: usernameInput,
                //     password: passwordInput
                // };

                jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                    if (response.success) {
                        alert('ログイン成功');

                        // Bootstrap 5 モーダルを閉じる方法
                        const modalEl = document.getElementById('loginModal');
                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        modal.hide();
                    } else {
                        document.getElementById('error-message').style.display = 'block';
                    }
                });
            });
        </script>


        <script>
            document.addEventListener('click', function(event) {
                // 1. ログイン済みユーザーは何もしない（WP の body_class() で 'logged-in' が付くので利用）
                if (document.body.classList.contains('logged-in')) return;

                // 2. 既にモーダル内をクリックした場合はスキップ
                if (event.target.closest('#loginModal .modal-content')) return;

                // 3. クリックされたのが送信ボタン（ログインボタン）の場合、何もしない
                if (event.target.closest('.btn-login')) return;

                // クリックされたらフォーム表示
                const modalEl = document.getElementById('loginModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });
        </script>



    </header>
    <main class="main">
