<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The prefix that'll be used for the administration
    |--------------------------------------------------------------------------
    */
    'admin-prefix' => 'backend',

    /*
    |--------------------------------------------------------------------------
    | Location where your themes are located
    |--------------------------------------------------------------------------
    */
    'themes_path' => base_path() . '/Themes',

    /*
    |--------------------------------------------------------------------------
    | Which administration theme to use for the back end interface
    |--------------------------------------------------------------------------
    */
    'admin-theme' => 'AdminMorvin',

    /*
    |--------------------------------------------------------------------------
    | AdminLTE skin
    |--------------------------------------------------------------------------
    | You can customize the AdminLTE colors with this setting. The following
    | colors are available for you to use: skin-blue, skin-green,
    | skin-black, skin-purple, skin-red and skin-yellow.
    */
    'skin' => 'skin-blue',

    /*
    |--------------------------------------------------------------------------
    | WYSIWYG Backend Editor
    |--------------------------------------------------------------------------
    | Define which editor you would like to use for the backend wysiwygs.
    | These classes are event handlers, listening to EditorIsRendering
    | you can define your own handlers and use them here
    | Options:
    | - \Modules\Core\Events\Handlers\LoadCkEditor::class
    | - \Modules\Core\Events\Handlers\LoadSimpleMde::class
    */
    'wysiwyg-handler' => \Modules\Core\Events\Handlers\LoadCkEditor::class,
    /*
    |--------------------------------------------------------------------------
    | Custom CKeditor configuration file
    |--------------------------------------------------------------------------
    | Define a custom CKeditor configuration file to instead of the one
    | provided by default. This is useful if you wish to customise
    | the toolbar and other possible options.
    */
    'ckeditor-config-file-path' => '',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    | You can customise the Middleware that should be loaded.
    | The localizationRedirect middleware is automatically loaded for both
    | Backend and Frontend routes.
    */
    'middleware' => [
        'backend' => [
            'auth.admin',
        ],
        'frontend' => [
        ],
        'api' => [
            'api',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Define which assets will be available through the asset manager
    |--------------------------------------------------------------------------
    | These assets are registered on the asset manager
    */
    'admin-assets' => [
        'apexcharts.js' => ['theme' => 'libs/apexcharts/apexcharts.min.js'] ,
        'app.css' => ['theme' => 'css/app.min.css'],
        'app.js' => ['theme' => 'js/app.js'],
        'bootstrap.css' => ['theme' => 'css/bootstrap.min.css'],
        'bootstrap-bundle.js' => ['theme' => 'libs/bootstrap/js/bootstrap.bundle.min.js'],
        'dashboard.js'=>['theme' => 'js/pages/dashboard.init.js'],
        'dropzone.js'=>['theme' => 'libs/dropzone/min/dropzone.min.js'],
        'icons.css' => ['theme' => 'css/icons.min.css'],
        'jquery-jvectormap.css' => ['theme' => 'libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'],
        'jquery.js' => ['theme' => 'libs/jquery/jquery.min.js'],
        'jvectormap.js' => ['theme' => 'libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js'],
        'jvectormap-world.js' => ['theme' => 'libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js'],
        'metisMenu.js' => ['theme' => 'libs/metismenu/metisMenu.min.js'],
        'simplebar.js' => ['theme' => 'libs/simplebar/simplebar.min.js'],
        'ckeditor.js'=> ['theme' =>'libs/tinymce/tinymce.min.js'],
        'waves.js' => ['theme' => 'libs/node-waves/waves.min.js'],

    ],

    /*
    |--------------------------------------------------------------------------
    | Define which default assets will always be included in your pages
    | through the asset pipeline
    |--------------------------------------------------------------------------
    */
    'admin-required-assets' => [
        'css' => [
            'jquery-jvectormap.css',
            'bootstrap.css',
            'icons.css',
            'app.css',
        ],
        'js' => [
            'jquery.js',
            'bootstrap-bundle.js',
            'metisMenu.js',
            'simplebar.js',
            'waves.js',
            'apexcharts.js',
            'jvectormap.js',
            'jvectormap-world.js',
            'app.js',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable module view overrides at theme locations
    |--------------------------------------------------------------------------
    | By default you can only have module views in resources/views/encore/[module]
    | setting this setting to true will add ability for you to store those views
    | in any of front or backend themes in my-theme/views/modules/[module]/...
    |
    | useViewNamespaces.backend-theme needs to be enabled at module level
    */
    'enable-theme-overrides' => false,

    /*
    |--------------------------------------------------------------------------
    | Check if encore was installed
    |--------------------------------------------------------------------------
    */
    'is_installed' => env('INSTALLED', false)
];
