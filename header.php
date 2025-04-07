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
    <title>OBOGクラブ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php wp_head(); ?>
</head>


<body>  
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
                    <button class="btn btn-outline-success" type="submit">会員専用ページ</button>
                    <button class="btn btn-outline-success" type="submit">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">弔事のご連絡について</a>
                    </button>
                    <button class="btn btn-outline-success" type="submit">ご入稿について（会員限定）</button>
                </div>
            </div>
        </nav>
    </header>
    <main class="main">