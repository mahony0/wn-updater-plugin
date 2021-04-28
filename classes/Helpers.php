<?php

namespace Mahony0\Updater\Classes;

use Cache;
use Hash;

class Helpers
{
    public function doUpdate()
    {
        // if security hash check needed
        if ($needsHashCheck = env('UPDATER_HASH_CHECK', true)) {
            date_default_timezone_set('UTC');

            $time = date('Y-m-d');
            $hashPayload = post('code');

            if (!Hash::check($time, $hashPayload)) {
                return [
                    'status' => false,
                    'payload' => 'Provided code did not match'
                ];
            }
        }

        $delay = env('UPDATER_DELAY', 60);

        if (Cache::has('wn_updater_plugin_ts')) {
            $lastUpdated = Cache::get('wn_updater_plugin_ts');

            if ((time() - $lastUpdated) <= ($delay * 60)) {
                return [
                    'status' => false,
                    'payload' => 'Update cannot be started because not enough time has passed since the last update'
                ];
            }
        }

        $ts = time();

        // composer update
        ini_set('max_execution_time', 300);

        $basepath = base_path();

        exec(
            "cd {$basepath} && composer update 2>&1",
            $execResponse
        );

        Cache::put('wn_updater_plugin_ts', $ts, $delay);

        return [
            'status' => true,
            'payload' => implode("\r\n", $execResponse)
        ];
    }
}
