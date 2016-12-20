<?php namespace Utils;

class Utils
{

    /**
     * Return the values from a single column in the input array
     * @param $array array
     * @param $key   string | int
     * @return array
     */
    static function array_pluck($array, $key)
    {
        return array_values(array_map(function ($item) use ($key) {
            return self::get($item, $key);
        }, $array));
    }

    static function get($item, $key)
    {
        if (is_array($item))
            return $item[$key];
        else
            return $item->{$key};
    }

    static function array_find_by($array, $key, $value)
    {
        foreach ($array as $item)
            if (self::get($item, $key) == $value) return $item;
    }

    /**
     * Only keep the given properties of items of the array
     * @param $array array
     * @param $key   array of string | int
     * @return array
     */
    static function array_select($array, $keys)
    {
        $keys = array_flip($keys);
        return array_map(function ($item) use ($keys) {
            return array_intersect_key($item, $keys);
        }, $array);
    }

    static function array_exclude_key($array, $excluded)
    {
        return array_filter(function ($key) use ($excluded) {
            return $key != $excluded;
        }, $array, ARRAY_FILTER_USE_KEY);
    }

    /**
     * If the condition is true, take the given number of items.
     * Else, return the entire array.
     * @param $condition bool
     * @param $n         int
     * @param $array     array
     * @return array
     */
    static function array_take_if($condition, $n, $array)
    {
        if ($condition)
            return array_slice($array, 0, $n);
        else
            return $array;
    }

    static function array_exclude_value($array, $value)
    {
        return array_values(array_diff($array, [$value]));
    }

    static function array_flatten($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = $result + self::array_flatten($value, $key);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * @param $function callable
     * @param $array    array
     * @return mixed
     */
    static function array_flatmap($function, $array)
    {
        return self::array_flatten(array_map($function, $array));
    }

    static function toArray($item)
    {
        return json_decode(json_encode($item));
    }

    static function removeDirectory($path)
    {
        if (is_dir($path)) {
            $files = glob($path . '/*');
            foreach ($files as $file) {
                removeDirectory($file);
            }
            rmdir($path);
        } else {
            unlink($file);
        }
    }
}
