<?php
return array(
    'container' => array(
        'pdo' => array(
            'component' => function () {
                    return new \Moss\Storage\Driver\PDO(
                        'mysql:dbname=database;host=localhost;port=3306',
                        'user',
                        'password',
                        new \Moss\Storage\Driver\Mutator(),
                        'prefix'
                    );
                },
            'shared' => true
        )
    )
);