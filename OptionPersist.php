<?php namespace Utils;


/**
 * Persist an object as wordpress option.
 */
trait OptionPersist
{
    /**
     * Get the object's options.
     * When the declared key isn't found, use the default.
     */
    function __construct()
    {
        $defaults = get_object_vars($this);
        $options  = get_option(self::$key) ?: $defaults;

        foreach ($options as $key => $undefined) {
            $this->$key = $options[$key];
        }
    }

    /**
     * Save the object's properties as options.
     */
    function __destruct()
    {
        $instancevars = get_object_vars($this);
        $classvars    = get_class_vars(self::class);
        $options      = array_intersect_key($instancevars, $classvars);
        update_option(self::$key, $options);
    }
}