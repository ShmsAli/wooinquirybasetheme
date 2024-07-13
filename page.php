<?php get_header(); ?>

<main class="wrapper flex-1 pb-8">

    <!-- <nav class="text-sm font-medium text-gray-500 mb-4 ">
        <?php
        if (woocommerce_breadcrumb())
            woocommerce_breadcrumb();
        ?>
    </nav> -->


    <!-- Hero Section -->
    <?php require_once('inc/hero-section.php'); ?>

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <!-- <h1><?php the_title(); ?></h1> -->
            <?php the_content(); ?>
    <?php
        endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>