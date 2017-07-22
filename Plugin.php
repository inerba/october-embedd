<?php namespace Inerba\Embedd;

use Backend;
use System\Classes\PluginBase;

/**
 * Embedd Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'inerba.embedd::lang.plugin.name',
            'description' => 'inerba.embedd::lang.plugin.description',
            'author'      => 'Inerba',
            'icon'        => 'icon-bolt'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Inerba\Embedd\Components\EmbedComponent' => 'EmbedComponent',
        ];
    }

    /**
     * Registers any form widgets implemented in this plugin.
     */
    public function registerFormWidgets()
    {
        return [
            'Inerba\Embedd\FormWidgets\EmbeddWidget' => [
                'label' => 'inerba.embedd::lang.plugin.name',
                'code' => 'embedd'
            ],
        ];
    }

    /**
     * Register snippets with the RainLab.Pages plugin.
     *
     * @return array
     * @see https://octobercms.com/plugin/rainlab-pages
     */
    public function registerPageSnippets()
    {
        return [
            'Inerba\Embedd\Components\EmbedComponent' => 'EmbedComponent',
        ];
    }

    public function registerSettings()
    {
        return [
            'general' => [
                'label'       => 'inerba.embedd::lang.settings_menu.label',
                'description' => 'inerba.embedd::lang.settings_menu.description',
                'icon'        => 'icon-link',
                'class'       => 'Inerba\Embedd\Models\Settings',
                'permissions' => ['inerba.embedd.settings'],
                'keywords'    => 'embedd inerba'
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'inerba.embedd.settings' => ['label' => 'inerba.embedd::lang.permissions.label'],
        ];
    }
}
