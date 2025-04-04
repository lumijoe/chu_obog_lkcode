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
        <button><a href="<?php echo home_url('/news'); ?>">中外炉工業OBOGクラブ</a></button>
        <nav>
            <ul>
                <li>
                    <button><a href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ一覧</a></button>
                    <!-- <a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>" target="_blank" rel="noopener noreferrer">お知らせ一覧</a> -->
                </li>

                <li>
                    <button><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" target="_blank" rel="noopener noreferrer">OBOGクラブについて</a></button>
                </li>
            </ul>
        </nav>

    </header>
    <main class="main">