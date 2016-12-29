<?php namespace Utils;

/**
 * Persist an object as Wordpress meta.
 */
trait MetaPersist
{
    /**
     * The post id of the parent object.
     * @var int
     */
    public $id;

    /**
     * The meta key to use for persistence.
     * @var string
     */
    static $key;

    /**
     * The function used to provide default values.
     * @return void
     */
    abstract function assignDefaults();

    /**
     * Restore the object using it's post's id.
     * @param $id string | null
     */
    function restore($id)
    {
        $meta = get_post_meta($id, self::$key, true);

        if ($id && $meta)
            foreach ($this->filterDeclared($meta) as $key => $value)
                $this->$key = $value;
        else
            $this->assignDefaults();
    }

    /**
     * Persist the object using it's post's id.
     * @return bool|int
     */
    function persist()
    {
        $asArray  = (array)$this;
        $declared = $this->filterDeclared($asArray);
        return update_post_meta($this->id, self::$key, $declared);
    }

    /**
     * Keep only the declared properties, to ensure integrity
     * @param $properties array
     * @return array
     */
    function filterDeclared($properties)
    {
        return array_intersect(get_class_vars(self::class), $properties);
    }
}