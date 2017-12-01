<?php
function wp_hugopress_scripts_basic()
{
    // Register the script like this for a plugin:
    wp_register_script('hugopress', plugins_url('/js/wp-hugopress.js', __FILE__ ));
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script('jquery');
    wp_enqueue_script('hugopress');
    wp_localize_script('hugopress', 'hugopress_post', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}

add_action('admin_enqueue_scripts', 'wp_hugopress_scripts_basic');
add_action('wp_enqueue_scripts', 'wp_hugopress_scripts_basic');
