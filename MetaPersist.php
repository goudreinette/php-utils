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
        $this->id = $id;
        $meta     = get_post_meta($this->id, self::$key, true) ?: $this->defaults();
        foreach ((array)$this as $key => $undefined) {
            $this->$key = $meta[$key] ?: $this->$key;
        }
    }

    /**
     * Save the object's properties as post meta.
     */
    function __destruct()
    {
        $meta = (array)$this;
        update_post_meta($this->id, self::$key, $meta);
    }
}