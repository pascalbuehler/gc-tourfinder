<?php

return [
    'apiEndpointUserLogs' => 'http://www.blain.ch/XRay/GetUsersGeocacheLogs.php',
    'apiParametersUserLogs' => [
        'token' => '46135ca5cb1634e99537f2734812ae8f',
        'username' => '',
        'from' => date('YYYYMMDD'),
        'to' => date('YYYYMMDD'),
    ],

    'apiEndpointSearchCaches' => 'http://www.blain.ch/XRay/SearchForGeocaches.php',
    'apiParametersSearchCaches' => [
        'token' => '46135ca5cb1634e99537f2734812ae8f',
        'CacheCodes' => '',
        'IsLite' => true,
    ],

    'googleApiToken' => 'AIzaSyAosOj7Iolove_4OswRjk-FZxidqvfJCho',
];
