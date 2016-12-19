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
        $options = get_option(self::$key) ?: [];

        foreach ($options as $key => $undefined) {
            $this->$key = $options[$key];
        }
    }

    /**
     * Save the object's properties as options.
     */
    function __destruct()
    {
        update_option(self::$key, $this);
    }
}