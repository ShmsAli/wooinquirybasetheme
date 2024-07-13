<?php
/*
Template Name: Send Inquiry Form Page
*/

$cart = WC()->cart;

// Initialize an empty array to store cart items
$cart_items_array = array();

get_header();
?>

<main class="wrapper mb-8">

    <!-- Hero Section -->
    <section class="mb-8  lg:block">
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
                <!-- <img src="<?php echo esc_url($hero_image); ?>" alt="Hero Product Image" class="w-full h-[250px] object-cover z-0"> -->
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri() . '/src/images.jpeg'; ?>" alt="Hero Product Image" class="w-full h-[250px] object-cover z-0">
            <?php endif; ?>
        </div>
    </section>

    <div class="flex flex-col gap-4 md:gap-12 md:flex-row w-full">
        <?php
        if (!$cart->is_empty()) : ?>
            <div id="cartItemsContainer" class="bg-white flex-1 w-full order-1 md:order-2">
                <h2 class="text-xl font-semibold mb-4"><?php esc_html_e('Inquiry Items', 'my-tailwind-theme'); ?></h2>
                <div id="cartItems" class="space-y-4">

                    <?php
                    foreach ($cart->get_cart() as $cart_item_key => $cart_item) :
                        // Get product data
                        $product = $cart_item['data'];

                        // Product name
                        $product_name = $product->get_name();

                        // Product image (assuming you want the thumbnail)
                        $product_image = $product->get_image(array(75, 75)); // Array specifies width and height

                        // Quantity
                        $quantity = $cart_item['quantity'];

                        $item_details = array(
                            'name'     => $product->get_name(),
                            'quantity' => $cart_item['quantity'],
                            'sku'      => $product->get_sku(),
                        );

                        // Add item details to the cart items array
                        $cart_items_array[] = $item_details;
                    ?>

                        <div class="flex gap-4">
                            <!-- <img src="path_to_product_image/${productID}.jpg" alt="${productName}" class="w-16 h-16 rounded mr-4"> -->
                            <?php echo $product_image; ?>
                            <div>
                                <h3 class="text-lg font-medium">
                                    <?php echo $product_name ?>
                                </h3>
                                <p class="text-gray-600 font-medium text-sm">
                                    Quantity : <?php echo $quantity ?>
                                </p>
                            </div>
                        </div>

                    <?php
                    endforeach;
                    $cart_items_json = json_encode($cart_items_array);
                    ?>
                </div>

            </div>
        <?php
        endif;
        ?>

        <div class="flex-1 w-full border p-6 sm:p-8 rounded-md order-2 md:order-1">
            <?php require_once('inc/send-inquiry-form.php') ?>
        </div>

    </div>
</main>


<?php get_footer(); ?>