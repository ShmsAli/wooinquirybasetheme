<?php get_header(); ?>

<main class="wrapper flex-1">
    <!-- Add this in your theme’s landing page template (e.g., front-page.php) -->
    <?php
    // Query slider images
    $slider_images = new WP_Query(array(
        'post_type' => 'slider_images', // Replace with your custom post type name if different
        'posts_per_page' => -1, // Retrieve all slider images
    ));

    if ($slider_images->have_posts()) :
    ?>
        <div x-data="{
    currentSlide: 0,
    images: [
        <?php while ($slider_images->have_posts()) : $slider_images->the_post(); ?>
        {
            url: '<?php the_post_thumbnail_url(); ?>',
            alt: '<?php the_title(); ?>'
        },
        <?php endwhile;
        wp_reset_postdata(); ?>
    ],
    timer: null,
    initSlider() {
        this.timer = setInterval(() => {
            this.nextSlide();
        }, 6000); // Change slide every 5 seconds
    },
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.images.length;
    },
    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.images.length) % this.images.length;
    },
    resetTimer() {
        clearInterval(this.timer);
        this.initSlider();
    }
    }" x-init="initSlider()" class="relative aspect-21/9 overflow-hidden">

            <div class="absolute inset-0 flex transition-transform duration-1000 ease-out" :style="{ transform: 'translateX(-' + currentSlide * 100 + '%)' }">

                <!-- Slider Images -->
                <template x-for="(image, index) in images" :key="index">
                    <div class="w-full flex-shrink-0">
                        <img :src="image.url" :alt="image.alt" class="w-full aspect-21/9 object-cover">
                    </div>
                </template>
            </div>

            <!-- Navigation Buttons -->
            <button @click="prevSlide(); resetTimer()" class="hidden sm:block absolute rounded-full left-2 top-1/2 transform -translate-y-1/2 p-2 bg-gray-800 hover:bg-gray-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </button>
            <button @click="nextSlide(); resetTimer()" class="hidden sm:block absolute rounded-full right-2 top-1/2 transform -translate-y-1/2 p-2 bg-gray-800 hover:bg-gray-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

        </div>
    <?php endif; ?>



    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <?php the_content(); ?>
    <?php
        endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>