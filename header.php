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


<body <?php body_class(); ?>>
    <?php if (!is_logged_in()) : ?>
        <?php get_template_part('template-parts/modal-login'); ?>
    <?php endif; ?>
    <header id="header" class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo home_url('/'); ?>">中外炉工業OBOGクラブ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/allevent'); ?>">全体行事</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/company'); ?>">会社だより</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/obog'); ?>">OBOG会だより</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/newscategory/member'); ?>">会員だより</a>
                        </li>
                    </ul>
                    <button class="btn btn-outline-success" type="submit">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">OBOGクラブについて</a>
                    </button>
                    <button class="btn btn-outline-success" type="submit">
                        <a href="<?php echo get_template_directory_uri(); ?>/images/home/chugairo_print.pdf" target="_blank">弔事のご連絡について</a>
                    </button>
                    <button class="btn btn-outline-success" type="submit">
                        <a href="<?php echo home_url('/about#memberpost'); ?>">ご入稿について（会員限定）</a>
                    </button>
                </div>
            </div>
        </nav>
        <!-- ログインボタン -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
            ログイン
        </button>
        <!-- ログインモーダル -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">ログイン</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">ユーザー名</label>
                                <input type="text" class="form-control" id="username" placeholder="ユーザー名を入力">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input type="password" class="form-control" id="password" placeholder="パスワードを入力">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">ログイン</button>
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
                    } else {
                        document.getElementById('error-message').style.display = 'block';
                    }
                });
            });
        </script>
    </header>
    <main class="main">