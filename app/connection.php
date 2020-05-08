<?php

declare(strict_types = 1);

use DI\Container;

return function(Container $container)
{
    $container->set('connection', function($container) {
        $connection = $container->get('settings')['connection'];

        $host = $connection['host'];
        $dbname = $connection['dbname'];
        $dbuser = $connection['dbuser'];
        $dbpass = $connection['dbpass'];

        try {
            $connection = new PDO("pgsql:host={$host};dbname={$dbname}", $dbuser, $dbpass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $connection;
    });
};