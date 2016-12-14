<?php namespace Utils;

class WooUtils
{
    /**
     * @param array $args Additional query arguments
     * @return Array [String] of product categories
     */
    static function getProductCategories($args = [])
    {
        $categories = get_categories(array_merge(['taxonomy' => 'product_cat', 'hierarchical' => true], $args));
        return array_values(Utils::array_pluck($categories, 'cat_name'));
    }

    /**
     * @param $date String
     * @param $time String
     * @return String date formatted to WooCommerce preferences
     */
    static function formatDateTimeWoocommerce($date, $time)
    {
        $formatted = date_i18n(wc_date_format(), strtotime($date));
        return "$formatted, $time uur";
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

    static function flattenMeta($ids, $metaKey)
    {
        foreach ($ids as $id) {
            $meta = get_post_meta($id, $metaKey, true);

            foreach ($meta as $subKey => $subValue) {
                $fullKey = "$metaKey-$subKey";
                update_post_meta($id, $fullKey, $subValue);
            }
        }
    }
}