<?php namespace Utils;

/**
 * Persist an object.
 */
trait Persist
{
    private function __construct($key = null)
    {
        $this->createTable();
        $this->key = $key;
        $values    = $this->query($key) ?: [];

        foreach ($defined as $key => $value) {
            $this->$key = $value;
        }
    }

    private function __destruct()
    {
        $table = "{$GLOBALS['wpdb']->prefix}persist";
        $row   = [
            'type'  => self::class,
            'value' => serialize($this)
        ];

        if ($this->key)
            $GLOBALS['wpdb']->update($table, $row, ['key' => $this->key]);
        else
            $GLOBALS['wpdb']->insert($table, $row);
    }

    private function query()
    {
        global $wpdb;
        $type   = self::class;
        $result = $wpdb->get_var("SELECT value FROM {$wpdb->prefix}persist WHERE key = $this->key AND type = '$type'");
        return json_decode($result, true);
    }


    private function createTable()
    {
        global $wpdb;
        $keyType = self::$keyType;
        return $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}persist (
                        key   $keyType      PRIMARY KEY NOT NULL UNIQUE,
                        type  VARCHAR(255)  NOT NULL,
                        value TEXT          NOT NULL
        )");
    }

    static function get($key)
    {
        return new self($key);
    }

    static function all()
    {
        global $wpdb;
        $type = self::class;
        $keys = $wpdb->get_col("SELECT key FROM {$wpdb->prefix}persist WHERE type = '$type'");
        return array_map(function ($key) {
            return new self((int)$key);
        }, $keys);
    }

    static function findOrCreate($key)
    {
        if ()
    }
}