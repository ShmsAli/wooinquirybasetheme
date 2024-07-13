<!-- Hero Section -->
<section class="wrapper lg:block">
    <div class="relative w-full h-[250px] flex flex-col justify-center items-center">
        <div class="absolute top-0 left-0 text-white w-full h-full flex flex-col justify-center items-center z-10 p-8 bg-black/50">

            <h1 class="text-xl md:text-2xl lg:text-4xl font-bold mb-2 text-center">
                <?php echo the_title(); ?>
            </h1>
            <?php
            if (woocommerce_breadcrumb())
                woocommerce_breadcrumb();
            ?>
        </div>
        <?php
        if (has_post_thumbnail()) :
            the_post_thumbnail('medium', array('class' => 'w-full h-[250px] object-cover z-0'));
        ?>
        <?php else : ?>
            <img src="<?php echo get_template_directory_uri() . '/images/images.jpeg'; ?>" alt="Hero Product Image" class="w-full h-[250px] object-cover z-0">
        <?php endif; ?>
    </div>
</section>