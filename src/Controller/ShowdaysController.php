<?php

namespace Controller;

use Core\InputParameters;
use DateInterval;
use DateTime;
use Helper\ApiHelper;

class ShowdaysController implements \Controller\ControllerInterface {
    public function run(): array {
        // Input parameters
        $from = new DateTime(InputParameters::get('from'));
        $to = new DateTime(InputParameters::get('to'));
        $input = array(
            'user' => InputParameters::get('user'),
            'from' => $from->format('d.m.Y'),
            'to' => $to->format('d.m.Y'),
        );

        // Get logs
        $logsRaw = ApiHelper::getUserLogs(InputParameters::get('user'), $from, $to);
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
            // Check date
            $visitDate = new DateTime(substr($logRaw['VisitDateIso'],0,10));
            if($visitDate<$from || $visitDate>$to) {
                continue;
            }

            $logs[$visitDate->format('Y-m-d')][] = $logRaw['CacheCode'];
            $cacheCodes[] = $logRaw['CacheCode'];
        }
        ksort($logs);

        // Get caches
        $cachesRaw = ApiHelper::getCaches(array_slice($cacheCodes, 0, 30));
        $caches = [];
        foreach($cachesRaw as $cache) {
            $caches[$cache['Code']] = $cache;
        }

        return [
            'input' => $input,
            'user' => $user,
            'logs' => $logs,
            'caches' => $caches
        ];
    }
}