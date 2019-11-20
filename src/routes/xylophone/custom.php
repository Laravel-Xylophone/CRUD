<?php

// --------------------------
// Custom Xylophone Routes
// --------------------------
// This route file is loaded automatically by Xylophone\Base.
// Routes you generate using Xylophone\Generators will be placed here.

Route::group([
    'prefix'     => config('xylophone.base.route_prefix', 'admin'),
    'middleware' => ['web', config('xylophone.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
}); // this should be the absolute last line of this file
