<?php

namespace Core;

use Helper\ConfigHelper;

class Router {
    const PAGE_HOME = 'home';
    const PAGE_SHOWDAYS = 'showdays';
    const PAGE_SHOWDAY = 'showday';
    
    public static function route($url) {
        $url = mb_substr($url, -1, 1)=='/' ? mb_substr($url, 0, -1) : $url;
        $urlpieces = strlen($url)>0 ? explode('/', $url) : [];

        // Home
        if(!is_array($urlpieces) || count($urlpieces)<1) {
            InputParameters::set('page', self::PAGE_HOME);
            return true;
        }
        
        // Show days
        if(count($urlpieces)==3 && strlen($urlpieces[0])>0 && date_parse($urlpieces[1])!==false && date_parse($urlpieces[2])!==false) {
            InputParameters::set('username', $urlpieces[0]);
            InputParameters::set('fromDate', $urlpieces[1]);
            InputParameters::set('toDate', $urlpieces[2]);
            InputParameters::set('page', self::PAGE_SHOWDAYS);
            return true;
        }

        // Show day
        if(count($urlpieces)==2 && strlen($urlpieces[0])>0 && date_parse($urlpieces[1])!==false) {
            InputParameters::set('username', $urlpieces[0]);
            InputParameters::set('day', $urlpieces[1]);
            InputParameters::set('page', self::PAGE_SHOWDAY);
            return true;
        }

        return false;
    }
}
