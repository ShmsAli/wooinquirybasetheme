<?php
// Assuming this is a WordPress template file for displaying archived products

get_header();
?>

<main x-data="{ sopen: false }" class=" pb-8">
    <!-- <div class="wrapper">
        <nav class="text-sm font-medium text-gray-500 w-full mb-4">
            <?php woocommerce_breadcrumb(); ?>
        </nav>
    </div> -->

    <!-- Hero Section -->
    <section class="wrapper mb-8  lg:block">
        <div class="relative w-full h-[250px] flex flex-col justify-center items-center">
            <div class="absolute top-0 left-0 text-white w-full h-full flex flex-col justify-center items-center z-10 p-8 bg-black/50">
                <?php if (is_product_category()) : ?>
                    <h1 class="text-xl sm:text-3xl lg:text-4xl font-bold mb-2 text-center"><?php single_cat_title(); ?></h1>
                <?php elseif (is_search()) : ?>
                    <h1 class="text-xl md:text-2xl lg:text-4xl font-bold mb-2 text-center">Search Results for: <?php echo get_search_query(); ?></h1>
                <?php elseif (is_shop()) : ?>
                    <h1 class="text-xl md:text-2xl lg:text-4xl font-bold mb-2 text-center">Products</h1>
                <?php elseif (is_archive()) : ?>
                    <h1 class="text-xl md:text-2xl lg:text-4xl font-bold mb-2 text-center">Products</h1>
                <?php endif; ?>
                <p class="text-sm font-medium text-center">Explore our collection of past products that have defined our brand.</p>
                <?php
                if (woocommerce_breadcrumb())
                    woocommerce_breadcrumb();
                ?>
            </div>
            <?php
            $hero_image = get_theme_mod('hero_product_image');
            if ($hero_image) : ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="Hero Product Image" class="w-full h-[250px] object-cover z-0">
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri() . '/images/images.jpeg'; ?>" alt="Hero Product Image" class="w-full h-[250px] object-cover z-0">
            <?php endif; ?>
        </div>
    </section>


    <!-- Sidebar Toggle Button (visible on small screens) -->
    <div class="wrapper lg:hidden">
        <button @click=" sopen=!sopen" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>


    <div class="wrapper mx-auto flex gap-6 lg:flex-row flex-col">
        <!-- Sidebar -->
        <aside :class="{ 'block': sopen, 'hidden': !sopen }" class="w-full lg:w-1/4 lg:block lg:mb-0 mb-8 text-sm">
            <div class="font-medium  rounded-lg mb-8">
                <h2 class="text-2xl font-bold mb-4">Categories</h2>
                <ul class="">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'parent'   => 0,
                        'hide_empty' => false,
                    ));
                    foreach ($categories as $category) {
                        $subcategories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'parent'   => $category->term_id,
                            'hide_empty' => false,
                        ));

                        $current_cat = get_queried_object();
                        $class = ($current_cat && $current_cat->term_id === $category->term_id) ? 'text-gray-900 bg-gray-300 ' : '';
                        $open = false;
                        if (!empty($subcategories)) {
                            foreach ($subcategories as $subcategory) {
                                $open = $current_cat && $current_cat->term_id === $subcategory->term_id;
                            }
                        }
                    ?>
                        <li class="w-full">
                            <div x-data="{open: <?php echo $open ? 'true' : 'false'; ?>}">

                                <div class="<?php echo $class; ?> p-2 border-gray-300 border-b w-full flex items-center justify-between">
                                    <a href="<?php echo get_term_link($category); ?>">
                                        <?php echo $category->name . ' (' . $category->count . ')'; ?>
                                    </a>
                                    <?php if (!empty($subcategories)) : ?>
                                        <span @click="open = !open" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                </div>


                                <?php
                                if (!empty($subcategories)) :

                                ?>
                                    <ul x-cloak x-show="open" class="mt-2 w-full">
                                        <?php
                                        foreach ($subcategories as $subcategory) :
                                            $subclass = ($current_cat && $current_cat->term_id === $subcategory->term_id) ? 'text-gray-900 bg-gray-300 ' : '';
                                        ?>
                                            <li class="w-full pl-2 <?php echo $subclass; ?> ">
                                                <a href="<?php echo get_term_link($subcategory); ?>" class="p-2 border-gray-300 border-b w-full block">
                                                    <?php echo $subcategory->name; ?>
                                                    (<?php echo $subcategory->count; ?>)
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

            <div class="font-medium mb-8">
                <h2 class="text-2xl font-bold mb-4">Tags</h2>
                <div class="flex flex-wrap">
                    <?php
                    $tags = get_terms('product_tag');
                    foreach ($tags as $tag) {
                        echo '<a href="' . get_term_link($tag) . '" class="text-sm border-gray-400 border hover:text-white text-gray-700 rounded-full px-3 py-1 m-1 hover:bg-gray-500">' . $tag->name . '</a>';
                    }
                    ?>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <section class="w-full lg:w-3/4">
            <section class="mb-8">
                <!-- <h2 class="text-2xl font-bold mb-4">Archived Products</h2> -->
                <?php
                if (have_posts()) :
                ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-2 gap-y-6">
                        <?php
                        while (have_posts()) : the_post();
                            // Get the gallery images
                            $gallery_images = get_post_meta(get_the_ID(), '_product_image_gallery', true);
                            $gallery_images_ids = explode(',', $gallery_images);
                        ?>
                            <div x-data="{ mainImage: '<?php echo get_the_post_thumbnail_url(); ?>' }" class="relative group" @mouseleave="mainImage = '<?php echo get_the_post_thumbnail_url(); ?>'">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img :src="mainImage" alt="<?php the_title(); ?>" class="w-full object-cover aspect-square">
                                    <?php endif; ?>
                                </a>
                                <!-- Show the products gallery images in a row when hover -->
                                <div class="w-full bg-white hidden group-hover:block transition-opacity duration-300">
                                    <div class="flex flex-wrap space-x-2">
                                        <?php foreach ($gallery_images_ids as $image_id) : ?>
                                            <?php $image_url = wp_get_attachment_url($image_id); ?>
                                            <?php if ($image_url) : ?>
                                                <img src="<?php echo $image_url; ?>" alt="Gallery Image" class="w-12 h-12 object-cover cursor-pointer mt-4" @mouseover="mainImage = '<?php echo $image_url; ?>'">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- Custom Add to Cart Button -->
                                    <div class="mt-4 flex gap-4 flex-wrap">
                                        <!-- <button class="bg-gray-700 sm:w-full text-white px-4 py-2 rounded hover:bg-gray-800" @click="addToCart(<?php echo get_the_ID(); ?>)">
                                            Add to Cart
                                        </button> -->
                                        <?php
                                        // Ensure WooCommerce is active and the function exists
                                        if (function_exists('woocommerce_template_loop_add_to_cart')) {
                                            woocommerce_template_loop_add_to_cart();
                                        }
                                        ?>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold mt-4"><?php the_title(); ?></h3>
                                <p class="text-sm font-medium text-gray-700"><?php echo wp_trim_words(get_the_excerpt(), 5); ?></p>
                            </div>
                        <?php
                        endwhile;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-end w-full">
                        <div class="mt-8 flex gap-2">
                            <!-- set here pagination -->
                            <?php
                            // Pagination with Tailwind CSS classes
                            echo '<div class="woocommerce-pagination flex justify-center">';
                            echo paginate_links(apply_filters('woocommerce_pagination_args', array(
                                'total'   => wc_get_loop_prop('total_pages'),
                                'current' => max(1, get_query_var('paged')),
                                'base'    => esc_url_raw(add_query_arg('paged', '%#%')),
                                'format'  => '?paged=%#%',
                                'type'      => 'list',
                                'mid_size' => 1,
                                'prev_next' => false,

                            )));
                            echo '</div>';
                            ?>
                        </div>
                    </div>
                <?php
                    wp_reset_postdata();
                else :
                ?>
                    <div class="flex justify-center w-full">
                        <p class="text-gray-700 py-4 font-medium text-lg">No product found!!!</p>
                    </div>
                <?php endif; ?>
            </section>
        </section>
    </div>
</main>


<?php get_footer(); ?>