<aside id="sidebar-news" class="widget-area aside-area">
    <h3 class="archive-label">アーカイブ</h3>
    <ul class="archive-wrapper">
        <?php
        wp_get_archives(array(
            'type'            => 'monthly', // 月別アーカイブ
            'post_type'       => 'news',    // カスタム投稿「news」専用
            'show_post_count' => true       // 投稿数を表示
        ));
        ?>
    </ul>
</aside>
