<?php

return [
    'baseUrl' => '',

    'apiEndpointUserLogs' => '',
    'apiParametersUserLogs' => [
        'token' => '',
        'user' => '',
        'from' => date('YYYYMMDD'),
        'to' => date('YYYYMMDD'),
    ],

    'apiEndpointSearchCaches' => '',
    'apiParametersSearchCaches' => [
        'token' => '',
        'CacheCodes' => '',
        'IsLite' => true,
    ],

    'apiEndpointLogs' => '',
    'apiParametersLogs' => [
        'token' => '',
        'code' => ''
    ],

    'googleApiToken' => '',
];
