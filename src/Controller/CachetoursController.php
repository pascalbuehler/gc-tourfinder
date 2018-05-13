<?php

namespace Controller;

use Core\InputParameters;
use DateTime;
use Helper\ApiHelper;
use Helper\ConfigHelper;

class CachetoursController implements ControllerInterface {
    public function run(): array {
        // Get logs
        $logsRaw = ApiHelper::getLogs(InputParameters::get('code'));

        // Get caches for the day of each log
        $cacheCounts = [];
        foreach($logsRaw['Logs'] as $logRaw) {
            // Check if it is a found log
            if($logRaw['LogType']['WptLogTypeId']!=2) {
                continue;
            }

            // Get logs from the user for the found date
            $user = $logRaw['Finder']['UserName'];
            $date = new DateTime(substr($logRaw['VisitDateIso'], 0, 10));
            $userLogsRaw = ApiHelper::getUserLogs($user, $date, $date);

            // Sum up the count for the found caches
            foreach($userLogsRaw as $userLogRaw) {
                // Check if it is a found log
                if($userLogRaw['LogType']['WptLogTypeId']!=2) {
                    continue;
                }
                if(!isset($cacheCounts[$userLogRaw['CacheCode']])) {
                    $cacheCounts[$userLogRaw['CacheCode']] = 1;
                }
                else {
                    $cacheCounts[$userLogRaw['CacheCode']]++;
                }
            }
        }

        // Calculate relative/absolute cache count
        if(count($cacheCounts)>0) {
            arsort($cacheCounts);
            $countTop = reset($cacheCounts);
            foreach($cacheCounts as $code => $count) {
                $cacheCounts[$code] = [
                    'countAbsolute' => $count,
                    'countRelative' => intval(round(100*$count/$countTop))
                ];
            }
        }

        // Limit to 35 (1-9 / A-Z)
        $cacheCounts = array_slice($cacheCounts, 0, 35);

        // Get cache infos
        $cachesRaw = ApiHelper::getCaches(array_keys($cacheCounts));
        $caches = [];
        foreach($cachesRaw as $cache) {
            $caches[$cache['Code']] = $cache;
        }

        // Resort
        uasort($caches, function($a, $b) use($cacheCounts) {
            $countsa = $cacheCounts[$a['Code']]['countAbsolute'];
            $countsb = $cacheCounts[$b['Code']]['countAbsolute'];
            if($countsa==$countsb) {
                return 0;
            }
            return ($countsa<$countsb) ? 1 : -1;
        });

        return [
            'config' => ConfigHelper::getConfig(),
            'code' => InputParameters::get('code'),
            'cacheCounts' => $cacheCounts,
            'caches' => $caches
        ];
    }
}