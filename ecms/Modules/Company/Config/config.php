<?php

return [
    'name' => 'Company',

    /*
   |--------------------------------------------------------------------------
   | Load additional view namespaces for a module
   |--------------------------------------------------------------------------
   | You can specify place from which you would like to use module views.
   | You can use any combination, but generally it's advisable to add only one,
   | extra view namespace.
   | By default every extra namespace will be set to false.
   */
    'useViewNamespaces' => [
        // Read module views from /Themes/<backend-theme-name>/views/modules/<module-name>
        'backend-theme' => true,
        // Read module views from /Themes/mo/views/modules/<module-name>
        'frontend-theme' => false,
        // Read module views from /resources/views/encore/<module-name>
        'resources' => false,
    ],

];
