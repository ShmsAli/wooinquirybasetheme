<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(' | ', 'echo', 'right'); ?><?php bloginfo('name'); ?></title>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body class="antialiased flex flex-col min-h-screen inter" <?php body_class(); ?>>
    <header x-transition id="header" class="border-b border bg-white">


        <!-- top bar -->
        <div id="top-bar" class="bg-gray-200 w-full hidden sm:block">
            <nav class="wrapper flex justify-between items-center py-2">
                <div class="text-sm font-medium text-gray-700">
                    <?php echo get_company_email(); ?>
                    |
                    <?php echo get_company_phone_number(); ?>
                </div>
                <div>
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
            </nav>
        </div>


        <!-- main bar -->
        <nav id="default-navbar" class="wrapper gap-2 lg:gap-0 lg:flex-row flex-col flex justify-between items-center py-2">

            <!-- first row -->
            <div class="flex items-center justify-between w-full lg:w-fit">
                <!-- logo -->
                <div class="headerLogo h-14">
                    <?php
                    if (has_custom_logo() & has_custom_logo()) {
                        echo get_custom_logo();
                    } else {
                        echo '<h1>' . bloginfo('name') . '</h1>';
                    }
                    ?>
                </div>

                <!-- responsivness and  buttons -->
                <div x-data="{ sidebarOpen: false }" class="flex gap-4 lg:hidden items-center justify-center">
                    <?php
                    if (class_exists('WooCommerce')) {
                        $cart_count = WC()->cart->get_cart_contents_count(); // Get the cart count
                    ?>
                        <div x-data="{ open: false }">
                            <div class="flex relative flex-col">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="relative flex items-center space-x-2" @mouseover="open = true" @mouseleave="open = false">
                                    <span class="cart-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                    </span>
                                    <div class="my-cart-count absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">

                                    </div>
                                </a>
                                <!-- <div x-show="open" class="p-4 absolute z-[100] right-0 top-full w-64 bg-white shadow-lg border border-gray-200" @mouseover="open = true" @mouseleave="open = false" x-cloak>
                                    <?php
                                    //  woocommerce_mini_cart();
                                    ?>
                                </div> -->
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Button to toggle sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen" class="bg-gray-700 hover:bg-gray-800 text-white px-2 py-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <!-- Sidebar -->
                    <div x-cloak x-transition x-show="sidebarOpen" @click.away="sidebarOpen = false" class="flex flex-col gap-4 lg:hidden z-[250]  h-screen p-4 sm:p-8 w-full sm:max-w-xl fixed top-0 left-0 bg-white sm:shadow-lg sm:shadow-gray-900 duration-300 ease-in-out" :class="{ '-translate-x-0': sidebarOpen }">
                        <!-- Sidebar content goes here -->

                        <button class="flex justify-end" @click="sidebarOpen = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m15 9-6 6" />
                                <path d="m9 9 6 6" />
                            </svg>
                        </button>
                        <div class="prose">
                            <h2> <?php echo bloginfo('name'); ?></h2>
                        </div>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class' => 'flex flex-col gap-2',
                            'container' => false,
                            'fallback_cb' => false,
                            'depth' => 2,
                            'walker' => new Custom_Responsive_Nav_Walker(),

                        ));
                        ?>

                        <div class="prose">
                            <h3> Stay Connected</h3>
                        </div>

                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'social',
                            'menu_class' => 'flex items-center gap-4',
                            'container' => false,
                            'fallback_cb' => false,
                            'walker' => new Custom_Social_Nav_Walker(),
                            // 'items_wrap' => '<ul x-data="{open:false}" x-on:mouseenter="open = true" x-on:mouseleave="open = false"   class="%2$s">%3$s</ul>',
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <!-- primary menu -->
            <div class="hidden lg:block">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'flex items-center gap-2',
                    'container' => false,
                    'fallback_cb' => false,
                    'depth' => 2,
                    'walker' => new Custom_Nav_Walker(),
                    // 'items_wrap' => '<ul x-data="{open:false}" x-on:mouseenter="open = true" x-on:mouseleave="open = false"   class="%2$s">%3$s</ul>',
                ));
                ?>
            </div>

            <!-- search and cart -->
            <div class="flex items-center gap-4 lg:w-fit w-full ">

                <?php
                if (class_exists('WooCommerce')) {
                ?>
                    <div x-data="{ open: false }" class="hidden lg:block">
                        <div class="flex relative flex-col">
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="relative flex items-center space-x-2" @mouseover="open = true" @mouseleave="open = false">
                                <span class="cart-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </span>
                                <div class="my-cart-count absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">

                                </div>
                            </a>
                            <!-- <div x-show="open" class="p-4 absolute z-[100] right-0 top-full w-64 bg-white shadow-lg border border-gray-200" @mouseover="open = true" @mouseleave="open = false" x-cloak>
                                <?php
                                // woocommerce_mini_cart(); 
                                ?>
                            </div> -->
                        </div>
                    </div>
                <?php }
                ?>

                <!-- Product Search -->
                <?php get_product_search_form(); ?>

            </div>

        </nav>

    </header>