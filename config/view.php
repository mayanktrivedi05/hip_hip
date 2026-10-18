<?php

$activeTheme = env('APP_THEME', 'default');

return [

    /*
    |--------------------------------------------------------------------------
    | Active Application Theme
    |--------------------------------------------------------------------------
    |
    | This value determines which theme directory under resources/views will
    | be used as the primary source for Blade templates.
    |
    */

    'theme' => $activeTheme,

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Priority order:
    | 1. Active Theme directory (e.g. resources/views/modern or resources/views/default)
    | 2. Default Theme fallback (resources/views/default)
    | 3. Global Views directory (resources/views)
    |
    */

    'paths' => [
        resource_path("views/{$activeTheme}"),
        resource_path('views/default'),
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
