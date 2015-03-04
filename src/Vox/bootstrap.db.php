<?php
use Moss\Container\ContainerInterface;

use Moss\Storage\Model\Model;

use Moss\Storage\Model\Definition\Field;

use Moss\Storage\Model\Definition\Index\Index;
use Moss\Storage\Model\Definition\Index\Primary;
use Moss\Storage\Model\Definition\Index\Foreign;
use Moss\Storage\Model\Definition\Index\Unique;

use Moss\Storage\Model\Definition\Relation\One;
use Moss\Storage\Model\Definition\Relation\Many;
use Moss\Storage\Model\Definition\Relation\OneTrough;
use Moss\Storage\Model\Definition\Relation\ManyTrough;

return array(
    'container' => array(
        'storage:modelbag' => array(
            'component' => function (ContainerInterface $container) {

                $models = [
                    'user'
                ];

                $bag = new \Moss\Storage\Model\ModelBag();
                foreach ($models as $model) {
                    $bag->set($container->get('storage:' . $model), $model);
                }

                return $bag;
            },
            'shared' => true
        ),
        'storage' => array(
            'component' => function (ContainerInterface $container) {
                return new \Moss\Storage\Query\Storage(
                    $container->get('storage:connection'),
                    $container->get('storage:modelbag')
                );
            },
            'shared' => true
        ),
        'storage:user' => array(
            'component' => function () {
                return new Model(
                    '\Vox\Entity\User',
                    'user',
                    [
                        new Field('id', 'integer', ['autoincrement']),
                        new Field('login', 'string', ['length' => 128]),
                        new Field('hash', 'string', ['length' => 255]),
                        new Field('token', 'string', ['null', 'length' => 255]),
                    ],
                    [
                        new Primary(['id']),
                    ],
                    []
                );
            },
        )
    )
);
