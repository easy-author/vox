<?php
return array(
    'container' => array(
        'storage:connection' => array(
            'component' => function () {
                $connectionParams = [
                    'dbname' => 'test',
                    'user' => 'user',
                    'password' => 'password',
                    'host' => 'localhost',
                    'driver' => 'pdo_mysql',
                    'charset' => 'utf8'
                ];

                return \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            },
            'shared' => true
        )
    )
);
