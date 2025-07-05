<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ModelRelationMapProvider::class,
    App\Providers\RoleServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    
    // Module Service Providers
    Modules\MyFile\Providers\MyFileServiceProvider::class,
];
