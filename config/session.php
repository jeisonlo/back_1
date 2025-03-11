<?php

use Illuminate\Support\Str;

return [

   
    'driver' => env('SESSION_DRIVER', 'cookie'),

 
    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

   

    'encrypt' => true,

  
    'files' => storage_path('framework/sessions'),

   
    'connection' => env('SESSION_CONNECTION'),


    'table' => 'sessions',


    'store' => env('SESSION_STORE'),

    

    'lottery' => [2, 100],

   
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),



    'path' => '/',



    'domain' => env('SESSION_DOMAIN'),

   

    'secure' => true,

  

    'http_only' => true,

  

    'same_site' => 'none',

   
    'partitioned' => false,

];
