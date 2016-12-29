<?php namespace Utils;

class PluginContext
{
    /**
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $base;

    /**
     * @var string
     */
    public $dir;
    /**
     * @var string
     */
    public $url;

    /**
     * @var \stdClass
     */
    public $controllers;

    /**
     * @var View
     */
    public $view;

    function __construct()
    {
        $this->getPaths();
        $this->instantiateControllers();
        add_action('plugins_loaded', [$this, 'loadTranslations']);
    }

    function getPaths()
    {
        $reflection      = new \ReflectionClass(static::class);
        $this->namespace = $reflection->getNamespaceName();
        $this->path      = $reflection->getFileName();
        $this->dir       = plugin_dir_path($this->path);
        $this->url       = plugin_dir_url($this->path);
    }

    function instantiateControllers()
    {
        $this->view        = new View($this->url);
        $this->controllers = new \stdClass();

        foreach (glob("$this->dir/source/controllers/*.php") as $file) {
            require_once $file;
            $className                     = basename($file, '.php');
            $lowercase                     = strtolower($className);
            $fullyQualified                = "\\$this->namespace\\$className";
            $controller                    = new $fullyQualified();
            $controller->view              = $this->view;
            $controller->context           = $this;
            $this->controllers->$lowercase = $controller;
        }
    }

    function loadTranslations()
    {
        load_plugin_textdomain($this->base, false, $this->base);
    }
}