<?php

return [
    'vehicle.vehicles' => [
        'all' => 'vehicle::vehicles.list resource all',
        'index' => 'vehicle::vehicles.list resource',
        'create' => 'vehicle::vehicles.create resource',
        'edit' => 'vehicle::vehicles.edit resource',
        'destroy' => 'vehicle::vehicles.destroy resource',
    ],
    'vehicle.brands' => [
        'index' => 'vehicle::brands.list resource',
        'create' => 'vehicle::brands.create resource',
        'edit' => 'vehicle::brands.edit resource',
        'destroy' => 'vehicle::brands.destroy resource',
    ],
// append

];
