<?php namespace Utils;


trait OptionPersist
{
    /**
     * Get the object's options.
     * When the declared key isn't found, use the default.
     */
    function __construct()
    {
        $classVars = get_class_vars(self::class);
        $options   = get_option(self::$key, $classVars);

        foreach ($classVars as $key => $undefined) {
            $this->$key = $options[$key];
        }
    }

    /**
     * Save the object's properties as options.
     */
    function __destruct()
    {
        $classVars = get_class_vars(self::class);
        $options   = array_intersect_key((array)$this, $classVars);
        update_option(self::$key, $options);
    }
}