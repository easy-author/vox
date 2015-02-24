<?php
return array(
    'import' => array(
        (array) require __DIR__ . '/../src/Vox/bootstrap.php',
        (array) require __DIR__ . '/../src/Vox/bootstrap.db.php',
        (array) require __DIR__ . '/../src/Vox/bootstrap.db.connection.php',

        (array) require __DIR__ . '/../src/Console/bootstrap.php',
    ),
);
