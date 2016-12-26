<?php namespace Utils;

abstract class Plugin
{
    function setup()
    {
        $childPath   = (new ReflectionClass(static::class))->getFileName();
        $pluginDir   = plugin_dir_path($childPath);
        $pluginUrl   = plugin_dir_url($childPath);
        $view        = new View($pluginUrl);
        $controllers = glob("$pluginDir/source/controllers/*.php");
        foreach ($controllers as $controller) {
            $className = basename($controller, '.php');
            require_once $controller;
            new $className($view);
        }
    }
}