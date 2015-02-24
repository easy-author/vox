<?php
namespace Console\Controller;

use Moss\Storage\Query\Query;
use Vox\Admin\Repository\UserRepository;

class FixtureController extends ConsoleController
{
    /** @var Query */
    protected $storage;

    /**
     * Creates instance used in controller
     */
    public function before()
    {
        $this->storage = $this->app->get('storage');
    }

    /**
     * Builds message structure
     *
     * @param string $operation
     * @param array  $entities
     *
     * @return string
     */
    protected function msg($operation, array $entities)
    {
        foreach ($entities as &$entity) {
            $entity = get_class($entity) . '#' . $this->identify($entity);
            unset($entity);
        }

        return PHP_EOL . $operation . PHP_EOL . "\t - " . implode(PHP_EOL . "\t - ", $entities) . PHP_EOL;
    }

    /**
     * Returns entity identifier
     *
     * @param object $entity
     *
     * @return string
     */
    private function identify($entity)
    {
        $ref = new \ReflectionClass($entity);

        if (!$ref->hasProperty('id')) {
            return spl_object_hash($entity);
        }

        $prop = $ref->getProperty('id');
        $prop->setAccessible(true);

        return $prop->getValue($entity);
    }

    public function userAction()
    {
        /** @var UserRepository $repository */
        $repository = $this->app->get('repository:user');

        $users = [
            ['test', 'test']
        ];

        $result = [];
        foreach ($users as $data) {
            list($login, $password) = $data;

            $entity = $repository->create(null, $login);
            $hash = $repository->getHashedPassword($password);
            $entity->setHash($hash);
            $repository->write($entity);

            $result[] = $entity;
        }

        return $this->response($this->msg('Added', $result));
    }
}
