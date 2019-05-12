<?php

$config = array(
    'autoload' => __DIR__ . '/vendor/autoload.php',
    'endpoint' => array(
        'localhost' => array(
            'scheme' => 'http', # or https
            'host' => '127.0.0.1',
            'port' => 8983,
            'path' => '/solr/',
        )
    )
);
