<?php


//update cart count
function update_cart_count()
{
    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_total = WC()->cart->get_cart_total();
    if ($cart_count > 0) {
        // echo sprintf(_n('%d item', '%d items', $cart_count, 'my-tailwind-theme'), $cart_count) . ' - ' . $cart_total;
        echo '<span class="bg-gray-800 text-white rounded-full text-xs font-bold w-5 h-5 flex items-center justify-center">' . $cart_count . "</span>";
    } else {
        echo __('', 'my-tailwind-theme');
    }
    wp_die();
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');


// Handle AJAX form submission send inquiry form
add_action('wp_ajax_submit_inquiry', 'submit_inquiry_callback');
add_action('wp_ajax_nopriv_submit_inquiry', 'submit_inquiry_callback'); // for non-logged in users

function submit_inquiry_callback()
{
    // Sanitize input data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);
    $country = sanitize_text_field($_POST['country']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        wp_send_json_error('Invalid email format.');
    }

    // Check if any required field is empty
    if (empty($name) || empty($email) || empty($message) || empty($country)) {
        wp_send_json_error('Please fill all required fields.');
    }

    // Email parameters
    // $admin_email = get_option('admin_email'); // Get admin email dynamically
    $admin_email = $email;
    $subject = 'New Inquiry';
    $message_body = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: $email";

    // Send email
    $mail_sent = wp_mail($admin_email, $subject, $message_body, $headers);

    if ($mail_sent) {
        wp_send_json_success('Form submitted successfully!');
    } else {
        wp_send_json_error('Error: Unable to send email. Please try again later.');
    }

    // Always exit to avoid further execution
    wp_die();
}

// Hero Image Setting
function mytheme_customize_register($wp_customize)
{
    // Add a section for the hero image
    $wp_customize->add_section('hero_image_section', array(
        'title' => __('Hero Image Settings', 'mytheme'),
        'priority' => 30,
    ));

    // Add a setting for the hero image
    $wp_customize->add_setting('hero_product_image', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    // Add a control to upload the image
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_product_image_control', array(
        'label' => __('Hero Product Image', 'mytheme'),
        'section' => 'hero_image_section',
        'settings' => 'hero_product_image',
    )));
}
add_action('customize_register', 'mytheme_customize_register');


// limit products in archeive products page
add_filter('loop_shop_per_page', 'custom_products_per_page', 20);

function custom_products_per_page($cols)
{
    // Set the number of products to display per page
    $cols = 6; // Change this number to the number of products you want per page
    return $cols;
}

// deque styles

add_action('wp_enqueue_scripts', 'disable_woocommerce_default_styles', 99);

function disable_woocommerce_default_styles()
{
    // Disable WooCommerce's styles
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
}


//ratings

function render_star_rating($rating)
{
    // Determine the number of filled stars
    $filled_stars = floor($rating);
    // Determine if there's a half star
    $half_star = $rating - $filled_stars >= 0.1 ? true : false;

    // Output filled stars
    for ($i = 0; $i < $filled_stars; $i++) {
        echo '<svg class="text-[#f5c211] w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#f5c211" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
              </svg>';
    }

    // Output half star if applicable
    if ($half_star) {

        echo '
        <div class="flex gap-0">
        <svg class="text-[#f5c211] w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 24 24" fill="#f5c211" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star-half">
        <path d="M12 17.8 5.8 21 7 14.1 2 9.3l7-1L12 2"/>
        </svg>

        <svg class="text-[#f5c211] w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star-half" transform = "scale(-1, 1)">
        <path d="M12 17.8 5.8 21 7 14.1 2 9.3l7-1L12 2"/>
        </svg>
        </div>
        
        ';
    }

    // Output empty stars for the remaining
    $empty_stars = 5 - ceil($rating);
    for ($i = 0; $i < $empty_stars; $i++) {
        echo '<svg class="text-[#f5c211] w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
              </svg>';
    }
}



// short codes

function custom_parent_product_categories_shortcode()
{
    // Get product categories
    $parent_categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent' => 0, // Get only parent categories
        'hide_empty' => false, // Show empty categories
    ));

    // Start output buffer
    ob_start();

    if (!empty($parent_categories) && !is_wp_error($parent_categories)) {
        echo '<div class="flex flex-col gap-12">';
        echo '<h1 class="text-4xl font-medium uppercase">Our Categories</h1>';
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">';

        foreach ($parent_categories as $category) {
            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            $image_url = wp_get_attachment_url($thumbnail_id);
            $image_url = $image_url ? esc_url($image_url) : 'https://via.placeholder.com/300'; // Fallback image if no thumbnail is found

            echo '<div class="relative bg-white rounded-lg shadow-md overflow-hidden">';
            echo '<a href="' . esc_url(get_term_link($category)) . '">';
            echo '<div class="overflow-hidden">';
            echo '<img class="w-full h-[300px] sm:h-[200px] md:h-[300px]  object-cover transition-transform duration-500 transform hover:scale-125" src="' . $image_url . '" alt="' . esc_attr($category->name) . '">';
            echo '</div>';
            echo '<div class="p-4">';
            echo '<h2 class="text-lg font-semibold text-gray-800">' . esc_html($category->name) . '</h2>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
    }

    // Return buffered output
    return ob_get_clean();
}
add_shortcode('custom_parent_product_categories', 'custom_parent_product_categories_shortcode');



function custom_products_shortcode($atts)
{
    ob_start();

    // Shortcode attributes
    $atts = shortcode_atts(array(
        'label' => 'Featured Products',
        'type' => 'featured', // Default type is 'featured'
        'limit' => 4 // Default number of products to display
    ), $atts);

    ob_start();

    // Arguments for the query
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $atts['limit'],
    );

    if ($atts['type'] === 'featured') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            ),
        );
    } elseif ($atts['type'] === 'new') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($atts['type'] === 'related') {
        global $product;
        $product_id = $product->get_id();

        // Get related products
        $related_product_ids = wc_get_related_products($product_id, $atts['limit']);

        // Arguments for the query
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $atts['limit'],
            'post__in' => $related_product_ids,
            'post__not_in' => array($product_id), // Exclude the current product
        );
    }


    // Execute the query
    $loop = new WP_Query($args);

    // Debug: print query to see if it works correctly
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log(print_r($args, true));
        error_log('Found products: ' . $loop->found_posts);
    }

    // if ($loop->have_posts()) {
    //     echo '<div class="flex flex-col gap-12">';
    //     echo '<h1 class="text-4xl font-medium uppercase">' . $atts['label'] . '</h1>';
    //     echo '<div class="grid grid-cols-1 gap-y-8 gap-x-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">';
    //     while ($loop->have_posts()) : $loop->the_post();
    //         global $product;

    //         $product_thumbnail_id = $product->get_image_id();
    //         $product_thumbnail_url = wp_get_attachment_image_src($product_thumbnail_id, 'full');
    //         $gallery_image_ids = $product->get_gallery_image_ids();

    //         echo '<div class="w-full">';
    //         echo '<a class="w-full flex aspect-square" href="' . get_the_permalink() . '">';

    //         // Check if gallery images exist
    //         if (!empty($gallery_image_ids)) {
    //             $first_gallery_image_url = wp_get_attachment_image_src($gallery_image_ids[0], 'full');
    //             echo '<img x-data="{ hover: false }" class="w-full transition duration-500 ease-in-out opacity-100 hover:opacity-100" :src="hover ? \'' . $first_gallery_image_url[0] . '\' : \'' . $product_thumbnail_url[0] . '\'" @mouseenter="hover = true" @mouseleave="hover = false" alt="product-image">';
    //         } else {
    //             echo '<img class="w-full" src="' . $product_thumbnail_url[0] . '" alt="product-image">';
    //         }

    //         echo '</a>';
    //         echo '<h2 class="mt-2 font-medium"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';

    //         echo '</div>';
    //     endwhile;
    //     echo '</div>';
    //     echo '</div>';
    // } else {
    //     echo __('No ' . $atts['label'] . ' found!');
    // }

    if ($loop->have_posts()) {
        echo '<div class="flex flex-col gap-12">';
        echo '<h1 class="text-2xl sm:text-3xl md:text-4xl font-medium uppercase">' . $atts['label'] . '</h1>';
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-2 gap-y-6">';
        while ($loop->have_posts()) : $loop->the_post();
            global $product;

            // Get the main product thumbnail
            $product_thumbnail_url = get_the_post_thumbnail_url();

            // Get the gallery images
            $gallery_image_ids = $product->get_gallery_image_ids();
            $gallery_images_urls = array_map('wp_get_attachment_url', $gallery_image_ids);

            echo '<div x-data="{ mainImage: \'' . $product_thumbnail_url . '\' }" class="relative group" @mouseleave="mainImage = \'' . $product_thumbnail_url . '\'">';
            echo '    <a href="' . get_the_permalink() . '">';
            if (has_post_thumbnail()) {
                echo '        <img :src="mainImage" alt="' . get_the_title() . '" class="w-full object-cover aspect-square">';
            }
            echo '    </a>';

            // Show the product's gallery images in a row when hovered
            echo '    <div class="w-full bg-white hidden group-hover:block transition-opacity duration-300">';
            echo '        <div class="flex flex-wrap space-x-2">';
            foreach ($gallery_images_urls as $image_url) {
                if ($image_url) {
                    echo '            <img src="' . $image_url . '" alt="Gallery Image" class="w-12 h-12 object-cover cursor-pointer mt-4" @mouseover="mainImage = \'' . $image_url . '\'">';
                }
            }
            echo '        </div>';

            // Custom Add to Cart Button
            echo '        <div class="mt-4 flex gap-4 flex-wrap">';
            // Ensure WooCommerce is active and the function exists
            if (function_exists('woocommerce_template_loop_add_to_cart')) {
                ob_start();
                woocommerce_template_loop_add_to_cart();
                $add_to_cart_button = ob_get_clean();
                echo $add_to_cart_button;
            }
            echo '        </div>';
            echo '    </div>';

            echo '    <h3 class="text-lg font-bold mt-4">' . get_the_title() . '</h3>';
            echo '    <p class="text-sm font-medium text-gray-700">' . wp_trim_words(get_the_excerpt(), 5) . '</p>';
            echo '</div>';
        endwhile;
        echo '</div>';
        echo '</div>';
    } else {
        echo __('No ' . $atts['label'] . ' found!');
    }


    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('custom_products', 'custom_products_shortcode');



// Register shortcode to display services
function display_services_shortcode($atts)
{
    // Shortcode attributes (if any, not used in this example)
    $atts = shortcode_atts(array(
        'post_type' => 'services', // Replace with your custom post type name if different
        'posts_per_page' => -1, // Retrieve all posts
        'order' => 'ASC', // Order by ascending (oldest first)
    ), $atts);

    // WP_Query to fetch services
    $services = new WP_Query(array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'order' => $atts['order'],
    ));

    ob_start(); // Start output buffering

    // Display services if there are posts
    if ($services->have_posts()) :
?>
        <!-- our services -->
        <div class="bg-gray-200/50 py-16 w-full block">
            <div class="wrapper">
                <h1 class="text-3xl md:text-5xl mb-8 font-semibold text-center"> Our Services</h1>
                <div class="flex gap-4 flex-col items-center justify-center flex-wrap w-full">
                    <?php
                    $count = 0;
                    while ($services->have_posts()) :
                        $services->the_post();
                        $count++;
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    ?>
                        <!-- Service Block -->
                        <div class="w-full p-8 flex flex-col sm:flex-row gap-12 items-center justify-center">
                            <!-- Thumbnail -->
                            <div class="flex-1 <?php echo $count % 2 == 1 ? 'sm:order-2 flex justify-end w-full' : ''; ?>">
                                <img class="lg:max-w-sm w-full aspect-square rounded-full object-cover" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                            <!-- Content -->
                            <div class="flex-1 flex gap-6 flex-col text-center sm:text-left <?php echo $count % 2 == 1 ? 'sm:order-1' : ''; ?>">
                                <!-- Title -->
                                <h2 class="text-3xl md:text-5xl font-semibold">
                                    <?php the_title(); ?>
                                </h2>
                                <!-- Description -->
                                <p>
                                    <?php the_content(); ?>
                                </p>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata(); // Reset post data query
                    ?>
                </div>
            </div>
        </div>
<?php
    endif;

    // Return buffered output
    return ob_get_clean();
}
add_shortcode('display_services', 'display_services_shortcode');
