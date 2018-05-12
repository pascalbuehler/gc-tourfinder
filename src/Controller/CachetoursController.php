<?php

namespace Controller;

use Core\InputParameters;
use DateTime;
use Helper\ApiHelper;
use Helper\ConfigHelper;

class CachetoursController implements ControllerInterface {
    public function run(): array {
        // Input parameters
        $fromDate = new DateTime(InputParameters::get('fromDate'));
        $toDate = InputParameters::get('toDate')!==false ? new DateTime(InputParameters::get('toDate')) : $fromDate;
        $input = array(
            'code' => InputParameters::get('code'),
            'fromDate' => $fromDate->format('d.m.Y'),
            'toDate' => $toDate->format('d.m.Y'),
        );
var_dump($input);

        // Get logs
        $logsRaw = ApiHelper::getLogs(InputParameters::get('code'));

        // Get caches for the same day of each log
        $foundCaches = [];
        foreach($logsRaw['Logs'] as $logRaw) {
            // Check if it is a found log
            if($logRaw['LogType']['WptLogTypeId']!=2) {
                continue;
            }

            // Get logs from the user for the found date
            $user = $logRaw['Finder']['UserName'];
            var_dump($user);
            $date = new DateTime(substr($logRaw['VisitDateIso'], 0, 10));
            $userLogsRaw = ApiHelper::getUserLogs($user, $date, $date);

            // Sum up the count for the found caches
            foreach($userLogsRaw as $userLogRaw) {
                // Check if it is a found log
                if($userLogRaw['LogType']['WptLogTypeId']!=2) {
                    continue;
                }
                var_dump($userLogRaw['CacheCode']);
                if(!isset($foundCaches[$userLogRaw['CacheCode']])) {
                    $foundCaches[$userLogRaw['CacheCode']] = 1;
                }
                else {
                    $foundCaches[$userLogRaw['CacheCode']]++;
                }
            }
        }

        if(count($foundCaches)>0) {
            arsort($foundCaches);
            $countTop = reset($foundCaches);
            foreach($foundCaches as $code => $count) {
                $foundCaches[$code] = [
                    'foundsAbsolute' => $count,
                    'foundsRelative' => intval(round(100*$count/$countTop))
                ];
            }
        }
        var_dump($foundCaches);

        exit();

        // Get caches
        $cachesRaw = ApiHelper::getCaches(array_keys($foundCaches));
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