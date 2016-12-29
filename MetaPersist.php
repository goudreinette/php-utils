<?php namespace Utils;

/**
 * Persist an object as Wordpress meta.
 */
trait MetaPersist
{
    use Persist;

    /**
     * The post id of the parent object.
     * @var int
     */
    public $id;

    /**
     * Restore the object using it's post's id.
     * @param $id string | null
     */
    function restore($id)
    {
        $this->id = $id;
        $this->assignDynamicDefaults();
        $meta = get_post_meta($id, self::$key, true);

        if ($id && $meta) {
            foreach ($this->filterDeclared($meta) as $key => $value)
                $this->$key = $value;
        }
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
}