<?php

/**
* Solr Settings - Config can be overriden on a per project basis
*/
return [

//    'enable' => false,
    'enable' => true,

    'endpoint' => [
        'localhost' => [
            'scheme'  => 'http',
            'host'    => '127.0.0.1',
            'port'    => 8983,
            'path'    => '/solr',
//            'core'    => null,
            'core'    => 'test',
            'timeout' => 15,
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
