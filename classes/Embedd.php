<?php namespace Inerba\Embedd\Classes;

use Cache;
use Embed\Embed;
use Inerba\Embedd\Models\Settings;

class Embedd
{
    public function retrieve($url,$cache_duration=60)
    {
        $embed = Cache::remember(str_slug($url), $cache_duration, function() use($url) {
            try {

                $info = $this->init_embed($url);

                return self::map_fields($info);

            } catch (\Exception $e) {
                // ERRORE
                return $e->getMessage();
            }
        });

        return $embed;
    }

    private function init_embed($url)
    {
        $settings = [
            'google' => [
                'key' => Settings::get('googlemaps_api_key', null),
            ],
            'soundcloud' => [
                'key' => Settings::get('soundcloud_client_id', null),
            ],
            'facebook' => [
                'key' => Settings::get('facebook_access_token', null),
            ],
        ];
        return Embed::create($url, $settings);
    }

    public static function embedd($url,$fields='code',$cache_duration=60){
        $settings = [
            'google' => [
                'key' => Settings::get('googlemaps_api_key', null),
            ],
            'soundcloud' => [
                'key' => Settings::get('soundcloud_client_id', null),
            ],
            'facebook' => [
                'key' => Settings::get('facebook_access_token', null),
            ],
        ];
        $embed = Cache::remember('twig-'.$fields.str_slug($url), $cache_duration, function() use($url,$fields,$settings) {
            $info = Embed::create($url, $settings);
            if($fields == 'all'){
                return self::map_fields($info);
            } else {
                return $info->{$fields};
            }
        });

        return $embed;
        
    }

    private static function map_fields($info)
    {
        return (object) [
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
    }
}
