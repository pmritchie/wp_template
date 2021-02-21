<?php

// Required Files
require get_template_directory().'/template-parts/items.php';
require get_template_directory().'/template-parts/sections.php';
// end

add_filter('intermediate_image_sizes_advanced', 'prefix_remove_default_images');
function prefix_remove_default_images($sizes)
{
    unset($sizes['small'], $sizes['medium'], $sizes['large'], $sizes['medium_large']); // 150px
    // 300px
    // 1024px
    // 768px
    return $sizes;
}

add_filter('post_thumbnail_html', 'remove_wps_width_attribute', 10);
add_filter('image_send_to_editor', 'remove_wps_width_attribute', 10);
remove_filter('the_content', 'wp_make_content_images_responsive');

function remove_wps_width_attribute($html)
{
    return preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
}

// first run setup
if (!function_exists('wpt_setup')) {
    if (!is_admin()) {
        add_action('wp_enqueue_scripts', 'my_jquery_enqueue', 11);
    }

    function my_jquery_enqueue()
    {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, null);
        wp_enqueue_script('jquery');
    }

    /**
     * Register Custom Navigation Walker.
     */
    function register_wpt_navwalker()
    {
        require_once get_template_directory().'/includes/class-wp-bootstrap-navwalker.php';
    }
    add_action('after_setup_theme', 'register_wpt_navwalker');

    define('GOOGLE_FONTS', 'Open+Sans:400,500,600,700|Source+Sans+Pro:600,700');
    /**
     * Manage google fonts of load_google_font()
     * set GOOGLE_FONTS constant in config.php.
     */
    function load_google_fonts()
    {
        if (!defined('GOOGLE_FONTS')) {
            return;
        }
        echo '<link href="https://fonts.googleapis.com/css?family='.GOOGLE_FONTS.'" rel="stylesheet" type="text/css" />'."\n";
    }
    add_action('wp_head', 'load_google_fonts', 1);

//Save fields json
function acf_json_save_point($path)
{
    return get_template_directory().'/includes/fields/json';
}

//Load fields json
add_filter('acf/settings/save_json', 'acf_json_save_point');
//---- Load JSON fields
function acf_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_template_directory().'/includes/fields/json/';

    return $paths;
}
add_filter('acf/settings/load_json', 'acf_json_load_point');


    //Page Slug Body Class
    function add_slug_body_class($classes)
    {
        global $post;
        if (isset($post)) {
            $classes[] = $post->post_name;
        }

        return $classes;
    }
    add_filter('body_class', 'add_slug_body_class');

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Theme General Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false,
        ]);
        acf_add_options_sub_page([
            'page_title' => 'Theme Navigation Settings',
            'menu_title' => 'Navigation',
            'parent_slug' => 'theme-general-settings',
        ]);
        acf_add_options_sub_page([
            'page_title' => 'Theme Social Media Settings',
            'menu_title' => 'Social Media',
            'parent_slug' => 'theme-general-settings',
        ]);
        acf_add_options_sub_page([
            'page_title' => 'Theme Contact Settings',
            'menu_title' => 'Contact',
            'parent_slug' => 'theme-general-settings',
        ]);
    }

    function wpt_setup()
    {
        load_theme_textdomain('template-theme', get_template_directory().'/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');

        add_theme_support('editor-styles');
        add_editor_style('assets/om-editor.css');

        //register nav menus
        register_nav_menus([
            'menu_primary' => esc_html__('Primary Menu', 'ott'),
            'menu_footer' => esc_html__('Footer Menu', 'ott'),
        ]);

        //custom featured image size
        add_theme_support('post-thumbnails');

        //html5 support & background & logo
        add_theme_support('html5', [
            'comment-list', 'comment-form', 'search-form', 'gallery',
            'caption',
        ]);

        add_theme_support('custom-background', apply_filters('wpt_custwpt_background_args', [
            'default-color' => 'ffffff',
            'default-image' => '',
        ]));

        add_theme_support('custom-logo', [
            'height' => 75,
            'width' => 170,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => ['site-title', 'site-description'],
        ]);

        //post formats
        add_theme_support('post-formats', [
            'video',
            'gallery',
            'audio',
        ]);
    }
}
add_action('after_setup_theme', 'wpt_setup');
// end

// excerpt
function wpt_excerpt_length($length)
{
    return 40;
}
add_filter('excerpt_length', 'wpt_excerpt_length', 999);

function wpt_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'wpt_excerpt_more');
// end

// editor style
function wpt_add_editor_styles()
{
    add_editor_style(get_template_directory_uri().'/assets/editor-style.css');
}
add_action('init', 'wpt_add_editor_styles');
// end

// Video embed responsive
function wpt_oembed_filter($html)
{
    return '<div class="embed-responsive embed-responsive-16by9">'.$html.'</div>';
}
add_filter('embed_oembed_html', 'wpt_oembed_filter', 10, 4);
add_filter('video_embed_html', 'wpt_oembed_filter');
// end

// facebook opengraph and twitter card meta add
function wpt_doctype_opengraph($output)
{
    return $output.'
		prefix="og: http://ogp.me/ns#"';
}
add_filter('language_attributes', 'wpt_doctype_opengraph');

function wpt_social_meta()
{
    global $post;
    if (is_single()) {
        if (has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        } else {
            $img_src = '';
        }

        if ($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace('', "'", $excerpt);
        } else {
            $excerpt = get_bloginfo('description');
        } ?>

<!-- facebook -->
<meta property="og:type"
	content="article" />
<meta property="og:title"
	content="<?php the_title(); ?>" />
<meta property="og:description"
	content="<?php echo esc_attr(strip_tags(get_the_excerpt())); ?>" />
<meta property="og:url"
	content="<?php the_permalink(); ?>" />
<meta property="og:image"
	content="<?php if (!empty($img_src)) {
            echo esc_url($img_src[0]);
        } ?>" />
<meta property="og:site_name"
	content="<?php bloginfo('name'); ?>" />
<!-- twitter -->
<meta name="twitter:card"
	content="summary" />
<meta name="twitter:title"
	content="<?php the_title(); ?>" />
<meta name="twitter:description"
	content="<?php echo esc_attr(strip_tags(get_the_excerpt())); ?>" />
<meta name="twitter:url"
	content="<?php the_permalink(); ?>" />
<meta name="twitter:image"
	content="<?php if (!empty($img_src)) {
            echo esc_url($img_src[0]);
        } ?>" />
<?php
    } else {
        return;
    }
}
add_action('wp_head', 'wpt_social_meta', 5);
// end

// Mega Menu
add_filter('walker_nav_menu_start_el', 'wpt_desktop_menu', 10, 4);
function wpt_desktop_menu($item_output, $item, $depth, $args)
{
    global $wp_query;
    if ('menu-desktop' !== $args->theme_location) {
        return $item_output;
    }

    if (in_array('om-megamenu', $item->classes)) {
        global $wp_query;
        global $post;
        $subposts = get_posts('numberposts=6&cat='.$item->object_id);
        $item_output .= '<div class="w-mega-menu"><div class="w-wrap">';
        foreach ($subposts as $post) {
            setup_postdata($post);
            $item_output .= '<div class="w-article"><a href="'.get_permalink($post->ID).'">';
            $item_output .= '<div class="lazy bg bg-50" data-src="'.get_the_post_thumbnail_url($post->ID, 'medium').'"></div>';
            $item_output .= '<span class="w-title">'.get_the_title($post->ID).'</span>';
            $item_output .= '</a></div>';
        }
        wp_reset_postdata();
        $item_output .= '</div></div>';
    }

    return $item_output;
}

// sidebars
add_action('widgets_init', 'wpt_widgets_init');
function wpt_widgets_init()
{
    if (function_exists('register_sidebar')) {
        register_sidebar([
            'name' => esc_html__('Main Sidebar', 'template-theme'),
            'id' => 'sidebar-main',
            'before_widget' => '<div id="%1$s" class="%2$s w-box">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="w-sidebar-title">',
            'after_title' => '</h4>',
        ]);
    }
}
// end

// Enqueue scripts and styles.
if (!function_exists('wpt_scripts')) {
    function wpt_scripts()
    {
        // Styles
        wp_enqueue_style('fontawesome-all-min', '//use.fontawesome.com/releases/v5.8.1/css/all.css', [], null);

        wp_enqueue_style('wpt-styles-main', get_template_directory_uri().'/css/style.css', [], null);

        wp_enqueue_script('script-custom-script', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js', [], null, true);
        wp_register_script('template-theme', get_template_directory_uri().'/js/app.js', ['jquery'], null, true);
        wp_enqueue_script('template-theme');
    }
}
add_action('wp_enqueue_scripts', 'wpt_scripts');
