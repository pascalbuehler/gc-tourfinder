<?php

namespace Controller;

use Core\InputParameters;
use DateInterval;
use DateTime;
use Helper\ApiHelper;
use Helper\ConfigHelper;

class UserToursController implements ControllerInterface {
    public function run(): array {
        // Input parameters
        $fromDate = new DateTime(InputParameters::get('fromDate'));
        $toDate = new DateTime(InputParameters::get('toDate'));
        $input = array(
            'username' => InputParameters::get('username'),
            'fromDate' => $fromDate->format('d.m.Y'),
            'toDate' => $toDate->format('d.m.Y'),
        );

        // Get logs
        $logsRaw = ApiHelper::getUserLogs(InputParameters::get('username'), $fromDate, $toDate);
        $logs = [];
        $cacheCodes = [];
        $user = [];
        $first = true;
        foreach($logsRaw as $logRaw) {
            // Gather user
            if($first) {
                $user = $logRaw['Finder'];
                $first = false;
            }
            // Prepare data
            $visitDate = new DateTime(substr($logRaw['VisitDateIso'],0,10));
            $logs[$visitDate->format('Y-m-d')][] = $logRaw['CacheCode'];
            $cacheCodes[] = $logRaw['CacheCode'];
        }
        ksort($logs);

        // Get caches
        $cachesRaw = ApiHelper::getCaches($cacheCodes);
        $caches = [];
        foreach($cachesRaw as $cache) {
            $caches[$cache['Code']] = $cache;
        }

        return [
            'config' => ConfigHelper::getConfig(),
            'input' => $input,
            'user' => $user,
            'logs' => $logs,
            'caches' => $caches
        ];
    }
}