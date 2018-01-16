<?php

namespace Helper;

use DateTime;

class ApiHelper {
    public static function getUserLogs(string $username, DateTime $from, DateTime $to) {
        $config = ConfigHelper::getConfig();
        $config['apiParametersUserLogs']['username'] = $username;
        $config['apiParametersUserLogs']['from'] = $from->format('Ymd');
        $config['apiParametersUserLogs']['to'] = $to->format('Ymd');
        $url = $config['apiEndpointUserLogs'].'?'.http_build_query($config['apiParametersUserLogs']);
        $data = self::callApi($url);

        return $data;
    }
    
    public static function getCaches(array $cacheCodes, bool $isLite = true) {
        $config = ConfigHelper::getConfig();
        $config['apiParametersSearchCaches']['CacheCodes'] = implode(',', $cacheCodes);
        $config['apiParametersSearchCaches']['IsLite'] = $isLite ? 'true' : 'false';
        $url = $config['apiEndpointSearchCaches'].'?'.http_build_query($config['apiParametersSearchCaches']);
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

