<?php
namespace Console\Controller;

use Moss\Http\Response\Response;
use Moss\Storage\StorageQuery;
use Moss\Storage\StorageSchema;

class StorageController extends ConsoleController
{
    /** @var StorageSchema */
    protected $schema;

    /**
     * Creates instance used in controller
     */
    public function before()
    {
        $this->schema = $this->app->get('schema');
    }

    /**
     * Gets entity names from request
     * If no names provided - gets all from registered models
     */
    protected function get()
    {
        $entities = (array) $this->app->request->query()
            ->get('entity', null);

        if (empty($entities)) {
            $entities = array_keys(
                $this->schema->getModels()
                    ->all()
            );
        }

        return $entities;
    }

    /**
     * Checks if storage has database entries for array of entities
     * 
     * @param array $entities
     * 
     * @return array
     */
    protected function check(array $entities)
    {
        $existing = array();
        $missing = array();

        foreach ($entities as $entity) {
            $check = $this->schema->check($entity)
                ->execute();

            if (reset($check)) {
                $existing[] = $entity;
            } else {
                $missing[] = $entity;
            }
        }

        return array($existing, $missing);
    }

    /**
     * Builds message structure
     * 
     * @param string $prefix
     * @param array $collection
     * 
     * @return string
     */
    protected function msg($prefix, array $collection)
    {
        $count = count($collection[2]);
        for ($i = 0; $i < 3; $i++) {
            if (empty($collection[$i])) {
                $collection[$i] = array('-none-');
            }
        }

        return sprintf(
            "%s (%u):\n\tEntities: %s\n\tSkipped: %s\n\tQueries:\n\t\t%s",
            $prefix,
            $count,
            implode(', ', $collection[0]),
            implode(', ', $collection[1]),
            implode("\n\t\t", $collection[2])
        );
    }

    /**
     * Lists queries needed to create misssing database tables
     * Add --force parameter to execute them
     * 
     * @return ResponseInterface
     */
    public function createAction()
    {
        $collection = $this->check($this->get());

        $query = $this->schema->create($collection[1]);

        $result = array(
            $collection[1],
            $collection[0],
            $query->queryString()
        );

        if ($this->app->request->query->get('force')) {
            $query->execute();

            return new Response($this->msg('Executed', $result), 200, 'text/plain; charset=UTF-8');
        }

        return new Response($this->msg('Preview', $result), 200, 'text/plain; charset=UTF-8');
    }

    /**
     * Lists queries needed to update tables - this also includes creation of non existing ones
     * Add --force parameter to execute them
     * 
     * @return ResponseInterface
     */
    public function updateAction()
    {
        $collection = $this->check($this->get());

        $create = array();
        if (!empty($collection[1])) {
            $create = $this->schema->create($collection[1]);
        }

        $update = $this->schema->alter($collection[0]);

        $result = array(
            array_merge($collection[1], $collection[0]),
            array(),
            array_merge(
                empty($create) ? array() : $create->queryString(),
                $update->queryString()
            )
        );

        if ($this->app->request->query->get('force')) {
            if(!empty($create)) {
                $create->execute();
            }

            $update->execute();

            return new Response($this->msg('Executed', $result), 200, 'text/plain; charset=UTF-8');
        }

        return new Response($this->msg('Preview', $result), 200, 'text/plain; charset=UTF-8');
    }

    /**
     * Lists queries needed to drop all tables
     * Add --force parameter to execute them
     * 
     * @return ResponseInterface
     */
    public function dropAction()
    {
        $collection = $this->check($this->get());

        $query = $this->schema->drop($collection[0]);

        $result = array(
            $collection[0],
            $collection[1],
            $query->queryString()
        );

        if ($this->app->request->query->get('force')) {
            $query->execute();

            return new Response($this->msg('Executed', $result), 200, 'text/plain; charset=UTF-8');
        }

        return new Response($this->msg('Preview', $result), 200, 'text/plain; charset=UTF-8');
    }
}
