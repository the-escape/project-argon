<?php

/**
 * Solr Settings - Config can be overridden on a per project basis
 */
return [

    'enable' => env('SOLR_ENABLE', false),

    'endpoint' => [
        'localhost' => [
            'scheme'  => env('SOLR_SCHEME', 'http'),
            'host'    => env('SOLR_HOST', '127.0.0.1'),
            'port'    => env('SOLR_PORT', 8983),
            'path'    => env('SOLR_PATH', '/solr'),
            'core'    => env('SOLR_CORE', 'test'),
            'timeout' => env('SOLR_TIMEOUT', 15),
        ],
    ],

    'entity' => [
        'types' => [],
        'fields' => [],
    ],

    'user' => [
        'fields' => [],
        'roles' => [],
    ],
];
