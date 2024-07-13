<?php get_header(); ?>

<main class="flex-1 pb-8">
    <!-- Hero Section -->
    <?php require_once('inc/hero-section.php'); ?>

    <div class="wrapper grid lg:grid-cols-2 gap-10 justify-center mt-8">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <h4 class="text-3xl md:text-5xl tracking-tighter max-w-xl text-left font-regular">
                        <?php bloginfo() ?>
                    </h4>
                    <p class="text-lg leading-relaxed tracking-tight text-muted-foreground max-w-sm text-left">
                        <?php echo get_bloginfo('description'); ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row gap-6 items-start text-left">
                <div class="flex flex-col gap-1">
                    <p>CEO</p>
                    <p class="text-muted-foreground text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>
                        <?php echo get_ceo_name() ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row gap-6 items-start text-left">
                <div class="flex flex-col gap-1">
                    <p>Phone Number</p>
                    <p class="text-muted-foreground text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        <a href="tel:<?php echo get_ceo_phone_number(); ?>">
                            <?php echo get_ceo_phone_number(); ?>
                        </a>
                    </p>
                </div>
            </div>
            <div class="flex flex-row gap-6 items-start text-left">
                <div class="flex flex-col gap-1">
                    <p>Email</p>
                    <p class="text-muted-foreground text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <a href="mailto:<?php echo get_ceo_email(); ?>?subject=Inquiry&body=Hello%20there,">
                            <?php echo get_ceo_email(); ?>
                        </a>
                    </p>
                </div>
            </div>
            <div class="flex flex-row gap-6 items-start text-left">
                <div class="flex flex-col gap-1">
                    <p>Address</p>
                    <p class="text-muted-foreground text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <?php echo get_address() ?>
                    </p>
                </div>
            </div>
            <div class="flex flex-row gap-6 items-start text-left">
                <div class="flex flex-col gap-2">
                    <p>Social Links</p>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'social',
                        'menu_class' => 'flex items-center gap-2',
                        'container' => false,
                        'fallback_cb' => false,
                        'walker' => new Custom_Social_Nav_Walker(),
                        // 'items_wrap' => '<ul x-data="{open:false}" x-on:mouseenter="open = true" x-on:mouseleave="open = false"   class="%2$s">%3$s</ul>',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="justify-center flex items-center">
            <div class="rounded-md flex flex-col border p-6 sm:p-8 gap-4">
                <h4 class="text-xl md:text-2xl tracking-tighter max-w-xl text-left font-regular">
                    Send Your Inquiry
                </h4>
                <?php require_once('inc/send-inquiry-form.php') ?>
            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>