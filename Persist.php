<?php namespace Utils;


trait Persist
{
    /**
     * Provide default values.
     * @return void
     */
    abstract function assignDynamicDefaults();

    /**
     * Restore the object.
     */
    abstract function restore();

    /**
     * Persist the object.
     */
    abstract function persist();

    /**
     * Keep only the declared properties, to ensure integrity.
     * Don't persist key and id.
     * @param $properties array
     * @return array
     */
    function filterDeclared($properties)
    {
        $declared = array_intersect_key($properties, get_class_vars(self::class));
        $meta     = array_diff_key($declared, array_flip(['id', 'key']));
        return $meta;
    }
}