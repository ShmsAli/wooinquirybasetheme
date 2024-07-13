<?php

/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<form role="search" method="get" class="woocommerce-product-search gap-2 flex items-center w-full" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"><?php esc_html_e('Search for:', 'woocommerce'); ?></label>
    <input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__('Search products&hellip;', 'woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <button class="form-input rounded-md bg-gray-700 hover:bg-gray-800 text-white focus:ring-gray-500 focus:outline-none focus:border-gray-200  active:border-gray-200" type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'woocommerce'); ?>" class="<?php echo esc_attr(wc_wp_theme_get_element_class_name('button')); ?>">
        <?php
        // echo esc_html_x('Search', 'submit button', 'woocommerce'); 
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>

    </button>
    <input type="hidden" name="post_type" value="product" />
</form>