<?php namespace Inerba\Embedd\Components;

use Cache;
use Embed\Embed;
use Cms\Classes\ComponentBase;

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
                'title'             => 'Url',
                'description'       => 'Url da embeddare',
                'type'              => 'string',
            ],
            'cache' => [
                'title'             => 'Cache in minuti',
                'description'       => 'Durata della cache in minuti, 0 per non usare la cache',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Please enter only numbers',
                'default'           => '1440',
                'type'              => 'string',
            ],
        ];
    }

    public function onRun()
    {
        /*$start = microtime(true);
        dd($this->retrieve(),microtime(true) - $start);*/

        $e = $this->retrieve();

        dd($e);

        if(!is_object($e)){
            // ERRORE
            $this->page['provider_partial'] = 'error';
            $this->page['error'] = $e;
            return false;
        }

        $this->page['provider_partial'] = $this->get_partial($e->providerName);
        $this->page['embed'] = $e;
    }

    public function retrieve()
    {
        $url = $this->property('url');
        $cache_duration = $this->property('cache');

        $embed = Cache::remember(str_slug($url), $cache_duration, function() use($url) {
            try {
                $info = Embed::create($url);

                $embed_array = [
                    'title' => $info->title, //The page title
                    'description' => $info->description, //The page description
                    'url' => $info->url, //The canonical url
                    'type' => $info->type, //The page type (link, video, image, rich)
                    'code' => $info->code, //The code to embed the image, video, etc
                    'width' => $info->width, //The width of the embed code
                    'height' => $info->height, //The height of the embed code
                    'aspectRatio' => $info->aspectRatio, //The aspect ratio (width/height)
                    'providerName' => $info->providerName, //The provider name of the page (Youtube, Twitter, Instagram, etc)
                    
                    'tags' => $info->tags, //The page keywords (tags)
                    'images' => $info->images, //List of all images found in the page
                    'image' => $info->image, //The image choosen as main image
                    'imageWidth' => $info->imageWidth, //The width of the main image
                    'imageHeight' => $info->imageHeight, //The height of the main image
                    'authorName' => $info->authorName, //The resource author 
                    'authorUrl' => $info->authorUrl, //The author url

                    'providerUrl' => $info->providerUrl, //The provider url
                    'providerIcons' => $info->providerIcons, //All provider icons found in the page
                    'providerIcon' => $info->providerIcon, //The icon choosen as main icon

                    
                    'publishedDate' => $info->publishedDate, //The published date of the resource
                    'license' => $info->license, //The license url of the resource
                    'linkedData' => $info->linkedData, //The linked-data info (http://json-ld.org/)
                    'feeds' => $info->feeds, //The RSS/Atom feeds
                    
                ];

                return $embed_array;
            } catch (\Exception $e) {
                // ERRORE
                return $e->getMessage();
            }
        });

        return $embed;
    }

    private function get_partial($name)
    {
        $name = str_slug($name);

        $filename = plugins_path('inerba/embedd/components/embedcomponent/'.$name.'.htm');

        if (file_exists($filename)) {
            return $name;
        }

        return false;
    }
}
