<?php

return [
    'plugin' => [
        'name'         => 'Embedd',
        'description'  => 'Provides easier-than-ever embedding.',
    ],

    'settings_menu' => [
        'label'        => 'Embedd',
        'description'  => 'Manage the Embedd plugin.',
    ],

    'permissions' => [
        'label'        => 'Manage Embedd plugin',
    ],

    'settings' => [

        'googlemaps_api_key' => [
            'label'   => 'Google Maps API Key',
            'comment' => 'Optional. If you\'re using the Google Maps embed, you\'ll have to specify a API key. See https://developers.google.com/maps/documentation/embed/guide#api_key'
        ],

        'soundcloud_client_id' => [
            'label'   => 'SoundCloud Client ID',
            'comment' => 'Optional. If you\'re using the SoundCloud Player, you\'ll have to specify a CLient ID. See https://developers.soundcloud.com/'
        ],

        'facebook_access_token' => [
            'label'   => 'Facebook access token',
            'comment' => 'Facebook access token'
        ],

    ],
];
