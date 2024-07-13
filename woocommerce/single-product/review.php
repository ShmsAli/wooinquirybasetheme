<?php

/**
 * Single Product Review
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $comment;

$author_id = $comment->user_id;

?>

<div class="py-6 gap-4 flex flex-col items-center">
    <div class="w-full max-w-xl">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex gap-2 text-sm items-center">
                    <img class="h-9 w-9 text-white flex items-center justify-center rounded-full" src=" <?php echo get_avatar_url($author_id, array('size' => 64)) ?> ">
                    <span class="text-xl">
                        <?php comment_author(); ?>
                        <span class="text-sm text-gray-500">
                            <?php echo get_comment_date('', $comment->comment_ID); ?>
                        </span>
                    </span>
                </div>
            </div>
            <div class="flex gap-0.5">
                <?php
                if (intval(get_comment_meta($comment->comment_ID, 'rating', true)))
                    render_star_rating(intval(get_comment_meta($comment->comment_ID, 'rating', true)));
                else
                    render_star_rating(0);
                ?>
            </div>
        </div>

        <div class="text-gray-700 text-base mt-4"><?php comment_text(); ?></div>
    </div>
    <div class="my-3 w-full max-w-xl border-b border-gray-300"></div>
</div>