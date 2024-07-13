<?php

// Include custom walker class
require_once get_template_directory() . '/inc/custom-nav-walker.php';

// Include Woo Commerce functions.php
require_once get_template_directory() . '/woocommerce/functions.php';


// adding scripts
function enqueue_jquery()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('js', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true);
    wp_localize_script('js', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

// include tailwind css
function my_tailwind_theme_enqueue_styles()
{
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/src/style.css', [], '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'my_tailwind_theme_enqueue_styles');

// include alpine js
function my_tailwind_theme_enqueue_scripts()
{
    // intersect plugin
    wp_enqueue_script('alpinejsIntersect', 'https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.14.1/dist/cdn.min.js', [], '3.14.1', true);
    wp_script_add_data('alpinejsIntersect', 'defer', true);

    // Enqueue Alpine.js on all pages by default
    wp_enqueue_script('alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js', array('alpinejsIntersect'), '3.14.1', true);
    wp_script_add_data('alpinejs', 'defer', true);
}
add_action('wp_enqueue_scripts', 'my_tailwind_theme_enqueue_scripts');


// adding feature image
add_theme_support('post-thumbnails');


// custom site logo
function theme_setup()
{
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 100,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'theme_setup');

function custom_logo_class($html)
{
    $html = str_replace('custom-logo', 'h-full w-full object-cover', $html);
    return $html;
}
add_filter('get_custom_logo', 'custom_logo_class');


// custom menus
function register_my_menu()
{
    register_nav_menu('primary', __('Primary Menu', 'textdomain'));
    register_nav_menu('categories', __('Categories Menu', 'textdomain'));
    register_nav_menu('social', __('SocialMedia Menu', 'textdomain'));
}
add_action('after_setup_theme', 'register_my_menu');


// Add custom fields to menu
function add_menu_svg_fields($item_id, $item, $depth, $args, $id)
{
    $menu_item_svg = get_post_meta($item_id, '_menu_item_svg', true);
?>
    <p class="field-svg description description-wide">
        <label for="edit-menu-item-svg-<?php echo esc_attr($item_id); ?>">
            <?php esc_html_e('Menu Item SVG', 'textdomain'); ?><br />
            <textarea id="edit-menu-item-svg-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-svg" name="menu-item-svg[<?php echo esc_attr($item_id); ?>]"><?php echo esc_textarea($menu_item_svg); ?></textarea>
        </label>
    </p>
<?php
}
add_action('wp_nav_menu_item_custom_fields', 'add_menu_svg_fields', 10, 5);

// Save custom field
function save_menu_svg_fields($menu_id, $menu_item_db_id)
{
    if (isset($_POST['menu-item-svg'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_svg', $_POST['menu-item-svg'][$menu_item_db_id]);
    }
}
add_action('wp_update_nav_menu_item', 'save_menu_svg_fields', 10, 2);


// Display custom field
function display_menu_item_svg($title, $item, $args, $depth)
{
    $menu_item_svg = get_post_meta($item->ID, '_menu_item_svg', true);
    if ($menu_item_svg) {
        $title = $menu_item_svg . $title;
    }
    return $title;
}
add_filter('nav_menu_item_title', 'display_menu_item_svg', 10, 4);



// woo commerce
function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');



// slider post type
function create_slider_post_type()
{
    register_post_type(
        'slider_images',
        array(
            'labels' => array(
                'name' => __('Slider Images'),
                'singular_name' => __('Slider Image')
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title', 'thumbnail')
        )
    );
}
add_action('init', 'create_slider_post_type');

// about us blocks post type

// about us blocks
function create_about_us_blocks_post_type()
{
    register_post_type(
        'about_us',
        array(
            'labels' => array(
                'name' => __('About Us Blocks'),
                'singular_name' => __('About Us Block')
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title', 'thumbnail', 'editor')
        )
    );
}
add_action('init', 'create_about_us_blocks_post_type');

// about us blocks
function create_services_blocks_post_type()
{
    register_post_type(
        'services',
        array(
            'labels' => array(
                'name' => __('Services Blocks'),
                'singular_name' => __('Services Block')
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title', 'thumbnail', 'editor')
        )
    );
}
add_action('init', 'create_services_blocks_post_type');



// Step 1: Register settings for SMTP
function my_smtp_register_settings()
{
    register_setting('smtp_settings_group', 'smtp_host');
    register_setting('smtp_settings_group', 'smtp_port');
    register_setting('smtp_settings_group', 'smtp_username');
    register_setting('smtp_settings_group', 'smtp_password');
    register_setting('smtp_settings_group', 'smtp_from');
    register_setting('smtp_settings_group', 'smtp_fromname');
}
add_action('admin_init', 'my_smtp_register_settings');

// Step 2: Add settings section and fields
function my_smtp_settings_init()
{
    add_settings_section(
        'smtp_settings_section',
        'SMTP Settings',
        'my_smtp_settings_section_callback',
        'smtp_settings'
    );

    add_settings_field(
        'smtp_host',
        'SMTP Host',
        'my_smtp_host_callback',
        'smtp_settings',
        'smtp_settings_section'
    );

    add_settings_field(
        'smtp_port',
        'SMTP Port',
        'my_smtp_port_callback',
        'smtp_settings',
        'smtp_settings_section'
    );

    add_settings_field(
        'smtp_username',
        'SMTP Username',
        'my_smtp_username_callback',
        'smtp_settings',
        'smtp_settings_section'
    );

    add_settings_field(
        'smtp_password',
        'SMTP Password',
        'my_smtp_password_callback',
        'smtp_settings',
        'smtp_settings_section'
    );

    add_settings_field(
        'smtp_from',
        'From Email',
        'my_smtp_from_callback',
        'smtp_settings',
        'smtp_settings_section'
    );

    add_settings_field(
        'smtp_fromname',
        'From Name',
        'my_smtp_fromname_callback',
        'smtp_settings',
        'smtp_settings_section'
    );
}
add_action('admin_init', 'my_smtp_settings_init');

// Step 3: Callbacks for settings section and fields
function my_smtp_settings_section_callback()
{
    echo 'Enter your SMTP settings below:';
}

function my_smtp_host_callback()
{
    $smtp_host = get_option('smtp_host');
    echo "<input type='text' name='smtp_host' value='$smtp_host' />";
}

function my_smtp_port_callback()
{
    $smtp_port = get_option('smtp_port');
    echo "<input type='text' name='smtp_port' value='$smtp_port' />";
}

function my_smtp_username_callback()
{
    $smtp_username = get_option('smtp_username');
    echo "<input type='text' name='smtp_username' value='$smtp_username' />";
}

function my_smtp_password_callback()
{
    $smtp_password = get_option('smtp_password');
    echo "<input type='password' name='smtp_password' value='$smtp_password' />";
}

function my_smtp_from_callback()
{
    $smtp_from = get_option('smtp_from');
    echo "<input type='text' name='smtp_from' value='$smtp_from' />";
}

function my_smtp_fromname_callback()
{
    $smtp_fromname = get_option('smtp_fromname');
    echo "<input type='text' name='smtp_fromname' value='$smtp_fromname' />";
}

// Step 4: Create settings page
function my_smtp_settings_page()
{
    add_options_page(
        'SMTP Settings',
        'SMTP Settings',
        'manage_options',
        'smtp_settings',
        'my_smtp_settings_page_html'
    );
}
add_action('admin_menu', 'my_smtp_settings_page');

// Step 5: Display settings page
function my_smtp_settings_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1>SMTP Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('smtp_settings_group');
            do_settings_sections('smtp_settings');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
}

// Step 6: Update SMTP configuration function
function my_custom_mail_smtp($phpmailer)
{
    $phpmailer->isSMTP();
    $phpmailer->Host       = get_option('smtp_host');
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = get_option('smtp_port');
    $phpmailer->Username   = get_option('smtp_username');
    $phpmailer->Password   = get_option('smtp_password');
    $phpmailer->SMTPSecure = 'tls';  // Use 'tls' for port 587, 'ssl' for port 465
    $phpmailer->From       = get_option('smtp_from');
    $phpmailer->FromName   = get_option('smtp_fromname');
}

add_action('phpmailer_init', 'my_custom_mail_smtp');




function mytheme_general_info_customize_register($wp_customize)
{
    // Add a section for the general information
    $wp_customize->add_section('general_info_section', array(
        'title'    => __('General Information', 'my-tailwind-theme'),
        'priority' => 32,
    ));

    // Add settings and controls for each field
    $fields = array(
        'company_email' => __('Company Email', 'my-tailwind-theme'),
        'ceo_email'     => __('CEO Email', 'my-tailwind-theme'),
        'ceo_name'      => __('CEO Name', 'my-tailwind-theme'),
        'company_phone_number'  => __('Company Phone Number', 'my-tailwind-theme'),
        'ceo_phone_number'  => __('CEO Phone Number', 'my-tailwind-theme'),
        'address'       => __('Address', 'my-tailwind-theme'),
    );

    foreach ($fields as $field => $label) {
        $wp_customize->add_setting($field, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Control($wp_customize, $field . '_control', array(
            'label'    => $label,
            'section'  => 'general_info_section',
            'settings' => $field,
            'type'     => 'text',
        )));
    }
}
add_action('customize_register', 'mytheme_general_info_customize_register');

function get_company_email()
{
    return get_theme_mod('company_email', '');
}

function get_ceo_email()
{
    return get_theme_mod('ceo_email', '');
}

function get_ceo_name()
{
    return get_theme_mod('ceo_name', '');
}

function get_company_phone_number()
{
    return get_theme_mod('company_phone_number', '');
}

function get_ceo_phone_number()
{
    return get_theme_mod('ceo_phone_number', '');
}

function get_address()
{
    return get_theme_mod('address', '');
}




