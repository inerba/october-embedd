<?php namespace Inerba\Embedd\Components;

use Cache;
use Embed\Embed;
use Cms\Classes\ComponentBase;
use Inerba\Embedd\Classes\Embedd;
use Inerba\Embedd\Models\Settings;

class EmbedComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'inerba.embedd::lang.plugin.name',
            'description' => 'inerba.embedd::lang.plugin.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'url' => [
                'title'             => 'inerba.embedd::lang.EmbedComponent.url.title',
                'description'       => 'inerba.embedd::lang.EmbedComponent.url.description',
                'type'              => 'string',
            ],
            'cache' => [
                'title'             => 'inerba.embedd::lang.EmbedComponent.cache.title',
                'description'       => 'inerba.embedd::lang.EmbedComponent.cache.description',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'inerba.embedd::lang.EmbedComponent.cache.validationMessage',
                'default'           => '1440',
                'type'              => 'string',
            ],
        ];
    }

    public function onRun()
    {
        /*$start = microtime(true);
        dd($this->retrieve(),microtime(true) - $start);*/
        $Embedd = new Embedd();
        $e = $Embedd->retrieve(
                $this->property('url'),
                $this->property('cache')
            );

        if(!is_object($e)){
            // ERRORE
            $this->page['provider_partial'] = 'error';
            $this->page['error'] = $e;
            return false;
        }
        $this->page['provider_partial'] = $this->get_partial($e->providerName);
        $this->page['embed'] = $e;
    }

    private function get_partial($name)
    {
        $name = str_slug($name);

        $filename = plugins_path('inerba/embedd/components/embedcomponent/provider/'.$name.'.htm');

        if (file_exists($filename)) {
            return $name;
        }

        return false;
    }

}
