<?php
$dbConnectionPath = __DIR__ . '/../src/Vox/bootstrap.db.connection.php';

return array(
    'import' => array(
        (array) require __DIR__ . '/../src/Vox/bootstrap.php',
        (array) require __DIR__ . '/../src/Vox/bootstrap.db.php',
        is_file($dbConnectionPath) ? (array) require $dbConnectionPath : [],

        (array) require __DIR__ . '/../src/Console/bootstrap.php',
    ),
);
