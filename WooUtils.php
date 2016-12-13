<?php namespace Utils;

class WooUtils
{
    /**
     * @param array $args Additional query arguments
     * @return Array [String] of product categories
     */
    function getProductCategories($args = [])
    {
        $categories = get_categories(array_merge(['taxonomy' => 'product_cat'], $args));
        return array_values(Utils::array_pluck($categories, 'cat_name'));
    }

    /**
     * @param $date String
     * @param $time String
     * @return String date formatted to WooCommerce preferences
     */
    function formatDateTimeWoocommerce($date, $time)
    {
        $formatted = date_i18n(wc_date_format(), strtotime($date));
        return "$formatted, $time uur";
    }

    /**
     * Events
     * @param \WC_Product $product
     * @return string
     */
    function featuredText(\WC_Product $product)
    {
        if ($product->is_featured())
            return "featured";
        if ($product->is_on_sale())
            return "sale";
    }
}