<?php namespace Utils;

class Utils
{

    /**
     * Return the values from a single column in the input array
     * @param $array array
     * @param $key   string | int
     * @return array
     */
    function array_pluck($array, $key)
    {
        return array_values(array_map(function ($item) use ($key) {
            if (is_array($item))
                return $item[$key];
            else
                return $item->{$key};
        }, $array));
    }

    /**
     * Only keep the given properties of items of the array
     * @param $array array
     * @param $key   array of string | int
     * @return array
     */
    function array_select($array, $keys)
    {
        $keys = array_flip($keys);
        return array_map(function ($item) use ($keys) {
            return array_intersect_key($item, $keys);
        }, $array);
    }

    /**
     * If the condition is true, take the given number of items.
     * Else, return the entire array.
     * @param $condition bool
     * @param $n         int
     * @param $array     array
     * @return array
     */
    function array_take_if($condition, $n, $array)
    {
        if ($condition)
            return array_slice($array, 0, $n);
        else
            return $array;
    }

    function array_apply_to($function, $keys, $array)
    {

    }
}
