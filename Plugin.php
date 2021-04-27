<?php

namespace Mahony0\Updater;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            "name" => "Auto Updater",
            "description" => "Plugin for updating WinterCMS via remote command",
            "author" => "Mahony0",
            "icon" => "icon-refresh"
        ];
    }

    public function boot()
    {
        //
    }
}
