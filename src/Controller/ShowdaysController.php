<?php

namespace Controller;

use Core\InputParameters;
use DateInterval;
use DateTime;
use Helper\ApiHelper;

class ShowdaysController implements \Controller\ControllerInterface {
    public function run(): array {
        $from = new DateTime(InputParameters::get('from'));
        $to = new DateTime(InputParameters::get('to'));
        $logs = ApiHelper::getUserLogs(InputParameters::get('user'), $from, $to);
        $logsCleaned = [];
        $cacheCodes = [];
        foreach($logs as $log) {
            $logsCleaned[] = $log['CacheName'].' ('.$log['CacheCode'].') - '.substr($log['VisitDateIso'],0,10);
            $cacheCodes[] = $log['CacheCode'];
        }

        $caches = ApiHelper::getCaches(array_slice($cacheCodes, 0, 30));
        $cachesCleaned = [];
        foreach($caches as $cache) {
            $cachesCleaned[] = $cache['Name'].' ('.$cache['Code'].') - '.$cache['Difficulty'].'/'.$cache['Terrain'].' - '.$cache['CacheType']['GeocacheTypeName'];
        }

        return [
            'logs' => $logsCleaned,
            'caches' => $cachesCleaned
        ];
    }
}