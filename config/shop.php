<?php

return [
   
    'media' => [
        'header' => 'http://',
        'host'   => env('MEDIA_HOST', ''),
        'user'   => env('MEDIA_USER', ''),
        'pass'   => env('MEDIA_PASS', ''),
        'root'   => env('MEDIA_ROOT', ''),
        'path'   => env('MEDIA_PATH', ''),
        'tempPath' => env('MEDIA_TEMP_PATH', '/temp'),
        'ip'   => env('MEDIA_IP', '39.107.246.53'),
    ],
];
    