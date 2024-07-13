<?php

/**
 * Product Review Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review-form.php.
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

?>

<div id="review_form_wrapper">
    <div id="review_form">
        <?php
        $commenter = wp_get_current_commenter();
        $comment_form_args = array(
            'title_reply' => __('Add a review', 'woocommerce'),
            'title_reply_to' => __('Leave a Reply to %s', 'woocommerce'),
            'fields' => array(
                'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'woocommerce') . ' <span class="required">*</span></label> ' .
                    ($req ? '<span class="required">*</span>' : '') .
                    '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
                'email'  => '<p class="comment-form-email"><label for="email">' . __('Email', 'woocommerce') . ' <span class="required">*</span></label> ' .
                    ($req ? '<span class="required">*</span>' : '') .
                    '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
            ),
            'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __('Your Review', 'woocommerce') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
            'label_submit' => __('Submit', 'woocommerce'),
            'logged_in_as' => '',
            'class_submit' => 'button',
        );

        comment_form($comment_form_args);
        ?>
    </div>
</div>