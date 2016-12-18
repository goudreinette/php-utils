<?php namespace Utils;

class WooUtils
{
    /**
     * @param array $args
     * @return \WP_Term[]
     */
    static function getProductCategories($args = [])
    {
        return get_categories(array_merge([
            'taxonomy'     => 'product_cat',
            'hierarchical' => true,
            'hide_empty'   => false
        ], $args));
    }

    /**
     * @param array $args
     * @return \WP_Term[]
     */
    static function getUsedProductCategories($args = [])
    {
        return self::getProductCategories(['hide_empty' => true]);
    }

    /**
     * @param $used bool
     * @return string[] of product categories
     */
    static function getProductCategoryNames($all = false)
    {
        $categories = $all
            ? self::getProductCategories()
            : self::getUsedProductCategories();

        return Utils::array_pluck($categories, 'cat_name');
    }


    /**
     * @param $date String
     * @return String date formatted to WooCommerce preferences
     */
    static function formatDateTimeWoocommerce($dateTime)
    {
        $timestamp = strtotime($dateTime);
        $date      = date_i18n(get_option('date_format'), $timestamp);
        $time      = date_i18n(get_option('time_format'), $timestamp);
        $postfix   = __('hrs', 'woo-events');
        return "$date, $time $postfix";
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