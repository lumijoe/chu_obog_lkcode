<?php

/**
 * custom_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package custom_theme
 */
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/images/logo.svg);
            margin:0!important;
            width:100%;
        }
        .login h1 a {
            background-size:100%important;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');