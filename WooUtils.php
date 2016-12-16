<?php namespace Utils;

class WooUtils
{
    /**
     * @param array $args Additional query arguments
     * @return Array [String] of product categories
     */
    static function getProductCategoryNames($args = [])
    {
        $categories = get_categories(array_merge(['taxonomy' => 'product_cat', 'hierarchical' => true], $args));
        return array_values(Utils::array_pluck($categories, 'cat_name'));
    }

    static function getProductCategories($args = [])
    {
        return get_categories(array_merge(['taxonomy' => 'product_cat', 'hierarchical' => true], $args));
    }

    /**
     * @param $date String
     * @return String date formatted to WooCommerce preferences
     */
    static function formatDateTimeWoocommerce($dateTime)
    {
        $date = date_i18n(wc_date_format(), strtotime($dateTime));
        $time = date('H:i', strtotime($dateTime));
        return "$date, $time uur";
    }

    /**
     * Events
     * @param \WC_Product $product
     * @return string
     */
    static function featuredText(\WC_Product $product)
    {
        if ($product->is_featured())
            return "featured";
        if ($product->is_on_sale())
            return "sale";
    }

    static function flattenMeta($id, $metaKey)
    {
        $meta = get_post_meta($id, $metaKey, true);

        foreach ($meta as $subKey => $subValue) {
            $fullKey = "$metaKey-$subKey";
            update_post_meta($id, $fullKey, $subValue);
        }
    }

    static function categoryLegacy($categoryId)
    {
        return array_merge(get_ancestors($categoryId, 'product_cat', 'taxonomy'), [$categoryId]);
    }
}