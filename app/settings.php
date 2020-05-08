<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'connection' => [
                'host'      => 'db',
                'dbuser'    => 'slim_user',
                'dbpass'    => 'secretP@55word',
                'dbname'    => 'slim_database',
            ],
            'doctrine' => [
                // if true, metadata caching is forcefully disabled
                'dev_mode' => true,

                // path where the compiled metadata info will be cached
                // make sure the path exists and it is writable
                'cache_dir' => __DIR__ . '/var/doctrine',

                // you should add any other path containing annotated entity classes
                'metadata_dirs' => [__DIR__ . '/src/Domain'],

                'connection' => [
                    'driver'    => 'pdo_pgsql',
                    'host'      => 'db',
                    'port'      => 4532,
                    'dbname'    => 'slim_database',
                    'user'      => 'slim_user',
                    'password'  => 'secretP@55word',
                    'charset'   => 'utf-8'
                ]
            ]
        ],
    ]);
};
