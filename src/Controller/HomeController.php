<?php

namespace Controller;

use DateInterval;
use DateTime;
use Helper\ApiHelper;

class HomeController implements \Controller\ControllerInterface {
    public function run(): array {
        $from = new DateTime();
        $interval = new DateInterval('P100D');
        $interval->invert = 1;
        $from->add($interval);
        $to = new DateTime();
        $logs = ApiHelper::getUserLogs('frigidor', $from, $to);
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