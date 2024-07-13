<form class="md:max-w-3xl flex justify-center mx-auto" id="inquiryForm">
    <input type="hidden" name="cart_items" id="cartItemsInput" value="<?php echo esc_attr($cart_items_json); ?>">

    <div class="flex flex-col gap-2">
        <!-- Name -->
        <div>
            <label for="name">Full Name <span class="required">*</span></label>
            <input type="text" id="name" class="" name="name" required />
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email <span class="required">*</span></label>
            <input type="text" id="email" class="" name="email" required />
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" class="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="e.g., 123-456-7890" name="phone" />
        </div>

        <div class="flex flex-wrap gap-4 w-full">
            <!-- Country -->
            <div class="flex-1">
                <label for="country">Country <span class="required">*</span></label>
                <input type="text" id="country" class="" name="country" required />
            </div>

            <!-- City / State -->
            <div class="flex-1">
                <label for="city">City / State</label>
                <input type="text" id="city" class="" name="city" />
            </div>
        </div>

        <!-- Message -->
        <div>
            <label for="message">Message<span class="required">*</span></label>
            <textarea name="message" id="message" rows="6" required></textarea>
        </div>

        <p class="text-sm font-medium text-gray-500">
            By submitting, you authorize <span class="text-gray-600"><?php bloginfo("blog_name") ?> </span>to text
            and call the number and send email to eamil address you provided with offers & other information, possibly using automated means.
        </p>

        <div class="flex mt-2 justify-end gap-4">
            <button id="reset-inquiry-button" type="reset" class="button">
                Reset
            </button>
            <button id="send-inquiry-button" type="submit" class="button">
                <?php esc_html_e('Send Inquiry', 'my-tailwind-theme'); ?>
            </button>
        </div>
    </div>
</form>