<?php

/*
* Template Name: Custom Single Product
*/

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        // Get the product ID
        $product_id = get_the_ID();

        // Get the main product image URL
        $product_thumbnail_id = get_post_thumbnail_id($product_id);
        $product_thumbnail_url = wp_get_attachment_image_src($product_thumbnail_id, 'full');
        $main_image_url = $product_thumbnail_url ? $product_thumbnail_url[0] : '';


        // Get all the imges IDs
        $product_gallery_ids_string = get_post_meta($product_id, '_product_image_gallery', true);
        $product_gallery_ids = explode(',', $product_gallery_ids_string);

        // Initialize an array to store image URLs
        $product_image_urls = array();
        $product_image_urls[] = $main_image_url;

        // Loop through image IDs and get their URLs
        foreach ($product_gallery_ids as $image_id) {
            $image_url = wp_get_attachment_image_src($image_id, 'full');
            if ($image_url) {
                $product_image_urls[] = $image_url[0];
            }
        }

        // Get the product categories URL
        $product_categories = wp_get_post_terms($product_id, 'product_cat');


?>

        <div class="w-full">
            <div class="wrapper py-8">
                <nav class="wrapper text-sm font-medium text-gray-500 mb-4 ">
                    <?php woocommerce_breadcrumb(); ?>
                </nav>
                <div class="flex flex-col md:flex-row gap-10 items-start justify-center py-10 lg:py-12">

                    <!-- Product Image -->
                    <!-- <div class="flex justify-center w-full flex-1">
                        <img src="<?php echo $product_image_url[0] ?>" class="w-full h-full aspect-square max-w-[500px] " alt="Prodcut Image">
                    </div> -->
                    <div class="flex justify-center w-full flex-1">
                        <div x-data="{
                            images: [
                                <?php foreach ($product_image_urls as $index => $image_url) : ?>
                                    '<?php echo $image_url ?>',
                                <?php endforeach; ?>
                            ],
                            currentImage: 0
                        }" class="w-full max-w-[500px] flex flex-col">

                            <div class="flex justify-center w-full mb-4">
                                <img :src="images[currentImage]" class="w-full h-full aspect-square" alt="Product Image">
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <template x-for="(image, index) in images" :key="index">
                                    <img :src="image" @click="currentImage = index" class="w-16 h-16 sm:w-20 sm:h-20 object-cover cursor-pointer border-2" :class="{'border-red-500': currentImage === index, 'border-transparent': currentImage !== index}" alt="Thumbnail">
                                </template>
                            </div>

                        </div>
                    </div>

                    <!-- Product Details -->

                    <div class="flex gap-4 flex-col flex-1">
                        <div>
                            <?php
                            if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                // Get the first category
                                $first_category = reset($product_categories);

                                // Output the category name
                                echo '<a class="text-gray-600" href="' . get_term_link($first_category) . '">' . $first_category->name . '</a>';
                            }
                            ?>
                        </div>
                        <div class="flex gap-2 flex-col">
                            <h2 class="text-4xl md:text-3xl lg:text-4xl tracking-tight lg:max-w-xl font-medium text-left">
                                <?php the_title(); ?>
                            </h2>
                            <div>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="flex gap-1">
                                        <?php
                                        render_star_rating($product->get_average_rating());
                                        ?>
                                    </span>
                                    <span class="text-gray-600 text-sm">(<?php echo $product->get_review_count() ?> customer reviews)</span>
                                </div>

                            </div>
                        </div>
                        <div class="border border-gray-200 border-b mt-4"></div>
                        <article class="prose max-w-none">
                            <?php echo get_the_excerpt(); ?>
                        </article>
                        <div class="my-4">
                            <?php
                            // Ensure WooCommerce is active and the function exists
                            if (function_exists('woocommerce_template_loop_add_to_cart')) {
                                woocommerce_template_loop_add_to_cart();
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="py-10 lg:py-12" x-data="{ activeTab: 'description' }">

                    <div class="flex gap-2 justify-center pb-4">

                        <button x-on:click="activeTab = 'description'" :class="{ 'border-gray-500 text-gray-800 border-2': activeTab === 'description', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'description' }" class="border whitespace-nowrap py-2 rounded-md shadow px-3  font-medium">
                            Description
                        </button>
                        <button x-on:click="activeTab = 'reviews'" :class="{ 'border-gray-500 text-gray-800 border-2': activeTab === 'reviews', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }" class="border whitespace-nowrap py-2 rounded-md shadow px-3  font-medium">
                            Reviews
                        </button>
                        <button x-on:click="activeTab = 'faqs'" :class="{ 'border-gray-500 text-gray-800 border-2': activeTab === 'faqs', ' text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'faqs' }" class="border whitespace-nowrap py-2 rounded-md shadow px-3  font-medium">
                            Questions
                        </button>
                    </div>

                    <div x-show="activeTab === 'description'" class="mt-8">
                        <!-- <h2 class="text-xl font-semibold">Description</h2> -->
                        <article class="prose lg:prose-lg max-w-none">
                            <?php the_content() ?>
                        </article>
                    </div>

                    <div x-show="activeTab === 'reviews'" class="mt-8">
                        <?php
                        // Check if reviews are enabled for the product
                        if (comments_open() || get_comments_number()) {
                            // Display the reviews section
                            comments_template();
                        } else {
                            // Display a message if reviews are disabled or not available
                            echo '<p>Reviews are disabled for this product.</p>';
                        }
                        ?>
                    </div>

                    <div x-show="activeTab === 'faqs'" class="mt-8">
                        <h2 class="text-xl font-semibold">FAQs</h2>
                        <p>Here are some frequently asked questions about this product.</p>
                    </div>
                </div>



                <?php

                echo do_shortcode('[custom_products type="related" label="You might interested in ..."]');
                ?>
            </div>
        </div>

<?php
    endwhile;
endif;

get_footer();
?>