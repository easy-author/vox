<?php
return array(
    'container' => array(
        'storage:connection' => array(
            'component' => function () {
                $connectionParams = [
                    'dbname' => '@database@',
                    'user' => '@user@',
                    'password' => '@password@',
                    'host' => '@host@',
                    'driver' => 'pdo_mysql',
                    'charset' => 'utf8'
                ];

                return \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            },
            'shared' => true
        )
    )
);
