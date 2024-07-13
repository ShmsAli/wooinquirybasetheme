<?php get_header(); ?>

<main class="flex-1">

    <!-- <nav class="text-sm font-medium text-gray-500 mb-4 ">
        <?php
        if (woocommerce_breadcrumb())
            woocommerce_breadcrumb();
        ?>
    </nav> -->


    <?php require_once('inc/hero-section.php'); ?>

    <!-- About Us Blocks -->
    <?php
    $about_us = new WP_Query(array(
        'post_type' => 'about_us', // Replace with your custom post type name if different
        'posts_per_page' => -1, // Retrieve all slider images
        'order' => 'ASC',
    ));

    if ($about_us->have_posts()) :
    ?>

        <!-- Information -->
        <div class="wrapper p-8">

            <?php
            $count = 0;
            while ($about_us->have_posts()) :
                $about_us->the_post();
                $count++;
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>

                <!-- About Our Company -->
                <div class="section flex gap-4 flex-col lg:flex-row items-center mb-8">
                    <div class="w-full flex-1 lg:p-16 <?php echo $count % 2 == 0 ? 'lg:order-2' : ''; ?>">
                        <img class="lg:max-w-lg w-full aspect-video object-cover" src="<?php echo $thumbnail_url ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="w-full flex-1 <?php echo $count % 2 == 0 ? 'lg:order-1' : ''; ?>">
                        <h1 class="text-2xl md:text-4xl text-gray-950 font-bold mb-8 tracking-wider">
                            <?php the_title(); ?>
                        </h1>
                        <p class="text-gray-700 leading-relaxed text-justify tracking-wide">
                            <?php the_content(); ?>
                        </p>
                    </div>
                </div>

            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    <?php
    endif;
    ?>


    <!-- Services Blocks -->
    <?php
    echo do_shortcode('[display_services]');
    ?>


</main>

<?php get_footer(); ?>