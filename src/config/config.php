<?php

return [
    'version'       => '1.1.7',
    'defaultRole'   => 'admin',
    'defaultRole'   => 'admin',
    'phpDateFormat' => 'd-m-Y',
    'jsDateFormat'  => 'DD-MM-YYYY',
    'paths'         => [
        'files'   => 'files',
        'avatars' => 'avatars',
        'imports' => 'imports',
        'temp'    => 'temp',
        'exports' => 'exports',
    ],
    'cacheLifetime' => env('CACHE_LIFETIME', 60),
];
