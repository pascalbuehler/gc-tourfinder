<?php

namespace Helper;

use DateInterval;
use DateTime;

class ApiHelper {
    public static function getUserLogs(string $username, DateTime $from, DateTime $to) {
        $config = ConfigHelper::getConfig();
        $apiParameters = $config['apiParametersUserLogs'];

        $apiParameters['username'] = $username;
        $apiParameters['from'] = $from->format('Ymd');
        // API serves not all caches up to "to" so we add some days
        $toCorrected = clone($to);
        $toCorrected->add(new DateInterval('P20D'));
        $apiParameters['to'] = $toCorrected->format('Ymd');
        $url = $config['apiEndpointUserLogs'].'?'.http_build_query($apiParameters);
        $data = self::callApi($url);

        // Check the date and sort out bad ones
        foreach($data as $key => $d) {
            $visitDate = new DateTime(substr($d['VisitDateIso'], 0, 10));
            if ($visitDate < $from || $visitDate > $to) {
                unset($data[$key]);
            }
        }

        // Sort by id
        usort($data, function($a, $b) {
            return ($a['ID'] < $b['ID']) ? -1 : 1;
        });

        return array_values($data);
    }
    
    public static function getCaches(array $cacheCodes, bool $isLite = true) {
        $config = ConfigHelper::getConfig();
        $apiParameters = $config['apiParametersSearchCaches'];
        $apiParameters['IsLite'] = $isLite ? 'true' : 'false';

        // API only serves max. 30 caches per call so we do chunks
        $data = [];
        $cacheCodesChunks = array_chunk($cacheCodes, 25);
        foreach($cacheCodesChunks as $cacheCodesChunk) {
            $apiParameters['CacheCodes'] = implode(',', $cacheCodesChunk);
            $url = $config['apiEndpointSearchCaches'].'?'.http_build_query($apiParameters);
            $dataChunk = self::callApi($url);
            $data = array_merge($data, $dataChunk);
        }

        return $data;
    }

    public static function getLogs(string $code) {
        $config = ConfigHelper::getConfig();
        $apiParameters = $config['apiParametersLogs'];

        $apiParameters['code'] = $code;
        $url = $config['apiEndpointLogs'].'?'.http_build_query($apiParameters);
        $data = self::callApi($url);

        return $data;
    }

    private static function callApi($url) {
        $data = file_get_contents($url);
        if(!$data) {
            throw new \Exception('Api not reachable ('.$url.')');
        }
        elseif($data=='null') {
            throw new \Exception('Api returned nothing ('.$url.')');
        }

        $data = json_decode($data, true);
        return $data;
    }
}

