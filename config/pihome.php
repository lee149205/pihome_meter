<?php

return [
    'timezone_default' => '+07:00',
    'version' => env('APP_VERSION', 'v1'),
    'jwt_key' => env('JWT_KEY'),
    'microservice' => [
        'log' => [
            'url' => env('MICROSERVICE_LOG_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'permission' => [
            'url' => env('MICROSERVICE_PERMISSION_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'order' => [
            'url' => env('MICROSERVICE_ORDER_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'apartment' => [
            'url' => env('MICROSERVICE_APARTMENT_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'partner' => [
            'url' => env('MICROSERVICE_PARTNER_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'utility' => [
            'url' => env('MICROSERVICE_UTILITY_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'fee' => [
            'url' => env('MICROSERVICE_FEE_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'service' => [
            'url' => env('MICROSERVICE_SERVICE_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'parking' => [
            'url' => env('MICROSERVICE_PARKING_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'community' => [
            'url' => env('MICROSERVICE_COMMUNITY_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'equipment' => [
            'url' => env('MICROSERVICE_EQUIPMENT_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'report' => [
            'url' => env('MICROSERVICE_REPORT_URL').'/'.env('APP_VERSION', 'v1')
        ],
        'user' => [
            'url' => env('MICROSERVICE_USER_URL').'/'.env('APP_VERSION', 'v1')
        ]
    ],
];
