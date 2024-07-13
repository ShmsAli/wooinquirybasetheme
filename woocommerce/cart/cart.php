<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;



do_action('woocommerce_before_cart'); ?>


<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <div class="mb-4">
        <?php do_action('woocommerce_before_cart_table'); ?>
    </div>

    <div class="w-full overflow-x-scroll">
        <table class="table-auto w-full border-collapse border border-gray-200 shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <thead>
                <tr class="bg-gray-100">

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        <span class="sr-only"><?php esc_html_e('Thumbnail image', 'woocommerce'); ?></span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        <?php esc_html_e('Product', 'woocommerce'); ?>
                    </th>
                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                    <?php esc_html_e('Price', 'woocommerce'); ?>
                </th> -->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        <?php esc_html_e('Quantity', 'woocommerce'); ?>
                    </th>
                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                    <?php esc_html_e('Subtotal', 'woocommerce'); ?>
                </th> -->

                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                        <span><?php esc_html_e('Remove item', 'woocommerce'); ?></span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                        <tr class="cart_item border-b border-gray-200">

                            <td class="p-2 whitespace-nowrap">
                                <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(array(100, 100)), $cart_item, $cart_item_key);

                                if (!$product_permalink) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                }
                                ?>
                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                if (!$product_permalink) {
                                    echo wp_kses_post($product_name . '&nbsp;');
                                } else {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                }

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                                echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification text-xs text-yellow-500">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                                ?>
                            </td>

                            <!-- <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                            </td> -->

                            <!-- Quantity -->
                            <td class="product-quantity px-6 py-4 whitespace-nowrap">
                                <?php
                                $product_quantity = woocommerce_quantity_input(
                                    array(
                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                        'input_value'  => $cart_item['quantity'],
                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                        'min_value'    => '0',
                                        'product_name' => $product_name,
                                    ),
                                    $_product,
                                    false
                                );

                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                ?>
                            </td>

                            <!-- <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                            </td> -->

                            <!-- delete item -->
                            <td class="product-remove px-6 py-4 whitespace-nowrap text-center">
                                <?php
                                echo apply_filters(
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="removed_from_cart text-red-600 hover:text-red-800 flex items-center justify-center" aria-label="%s" data-product_id="%s" data-product_sku="%s">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku())
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            </td>

                        </tr>
                <?php
                    }
                }
                ?>

                <?php do_action('woocommerce_cart_contents'); ?>

                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <?php if (wc_coupons_enabled()) { ?>
                            <div class="flex items-center justify-end">
                                <label for="coupon_code" class="sr-only"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                                <input type="text" name="coupon_code" class="py-2 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                                <button type="submit" class="ml-3 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                                <?php do_action('woocommerce_cart_coupon'); ?>
                            </div>
                        <?php } ?>

                        <div class="flex gap-4 items-center justify-end mt-4">

                            <!-- Update Cart -->
                            <button type="submit" class="update-cart cursor-pointer button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
                                <?php esc_html_e('Update cart', 'woocommerce'); ?>
                            </button>

                            <!-- Send Inquiry -->
                            <div class="">
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('send-inquiry'))); ?>" class="send-inquiry button"><?php esc_html_e('Send Inquiry', 'woocommerce'); ?></a>
                                <?php do_action('woocommerce_cart_actions'); ?>
                                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                            </div>

                        </div>

                    </td>
                </tr>

                <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>
        </table>
    </div>

    <?php do_action('woocommerce_after_cart_table'); ?>
</form>


<?php do_action('woocommerce_before_cart_collaterals'); ?>

<div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    // do_action('woocommerce_cart_collaterals');
    ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>