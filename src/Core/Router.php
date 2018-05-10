<?php

namespace Core;

use Helper\ConfigHelper;

class Router {
    const PAGE_HOME = 'home';
    const PAGE_USERTOURS = 'usertours';

    public static function route($url) {
        $url = mb_substr($url, -1, 1)=='/' ? mb_substr($url, 0, -1) : $url;
        $urlpieces = strlen($url)>0 ? explode('/', $url) : [];

        // User tours
        if(isset($urlpieces[0]) && $urlpieces[0]==self::PAGE_USERTOURS) {
            $input = InputParameters::getAll();
            if(isset($input['username']) && isset($input['fromDate'])) {
                InputParameters::set('page', self::PAGE_USERTOURS);
                return true;
            }
        }

        // Home (default)
        InputParameters::set('page', self::PAGE_HOME);
        return true;
    }
}
