<?php
// custom-nav-walker.php

class Custom_Nav_Walker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {

        $output .= '<ul class="absolute top-6 left-0 z-10">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Check if the current item is the active menu item
        $is_current = in_array('current-menu-item', $item->classes);

        // Define additional classes based on the active state
        $li_classes = $is_current ? 'relative py-1 rounded-md bg-gray-100 border' : 'relative border py-1 rounded-md hover:bg-gray-100';
        $anchor_classes = $is_current ? 'px-4 py-3 font-medium' : 'px-4 py-3 font-medium';

        // Output the <li> element with the appropriate classes
        $output .= '<li class="' . esc_attr($li_classes) . '">
                    <a class="' . esc_attr($anchor_classes) . '" href="' . esc_url($item->url) . '">' . $item->title;
    }


    function end_el(&$output, $item, $depth = 0, $args = \null)
    {
        $output .= "</a></li>";
    }
}


class Custom_Responsive_Nav_Walker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {

        $output .= '<ul class="absolute top-6 left-0 z-10">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Check if the current item is the active menu item
        $is_current = in_array('current-menu-item', $item->classes);

        // Define additional classes based on the active state
        $li_classes = $is_current ? 'relative py-1 rounded-md bg-gray-100 border' : 'relative border py-1 rounded-md hover:bg-gray-100';
        $anchor_classes = $is_current ? 'px-4 font-medium text-gray-800' : 'px-4 font-medium hover:text-gray-800';

        // Output the <li> element with the appropriate classes
        $output .= '<li class="' . esc_attr($li_classes) . '">
                    <a class="flex w-full py-1 ' . esc_attr($anchor_classes) . '" href="' . esc_url($item->url) . '">' . $item->title;
    }


    function end_el(&$output, $item, $depth = 0, $args = \null)
    {
        $output .= "</a></li>";
    }
}

class Custom_Footer_Nav_Walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'mb-4 hover:underline'; // Add your custom class here

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="'   . esc_attr($item->url) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}


class Custom_Social_Nav_Walker extends Walker_Nav_Menu
{

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Get SVG and title
        $svg = get_post_meta($item->ID, '_menu_item_svg', true);
        $title = apply_filters('the_title', $item->title, $item->ID);

        // Build the menu item
        $output .= '<li id="menu-item-' . $item->ID . '">';
        // $output .= ' class="menu-item menu-item-type-' . $item->type . ' menu-item-object-' . $item->object . ' menu-item-' . $item->ID . '">';
        $output .= '<a href="' . $item->url . '" class="menu-link text-gray-600">';
        if ($svg) {
            $output .= $svg;
        } else
            $output .= '<span class="menu-title">' . $title . '</span>';
        $output .= '</a>';
    }
}


