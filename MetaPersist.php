<?php namespace Utils;

/**
 * Persist an object as wordpress meta.
 */
trait MetaPersist
{
    /**
     * Get the object's post meta.
     * When the declared key isn't found, use the default.
     */
    function __construct($id)
    {
        return unserialize(get_post_meta($this->id, self::$key, true));
    }

    /**
     * Save the object's properties as post meta.
     */
    function __destruct()
    {
        update_post_meta($this->id, self::$key, serialize($this));
    }
}