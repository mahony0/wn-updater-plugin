<?php

App::before(function($request) {

    // updater route definition
    $routeName = env('UPDATER_ROUTE', 'wn-updater-plugin/update');

    Route::post($routeName, function() {
        if ($active = env('UPDATER_ENABLED', true)) {
            $result = (new \Mahony0\Updater\Classes\Helpers())->doUpdate();
        } else {
            $result = [
                'status' => false,
                'payload' => 'Updater is disabled'
            ];
        }

        return response()->json($result);
    });

});
