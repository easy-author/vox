<?php
namespace Console\Controller;

use Moss\Http\Response\Response;
use Moss\Http\Response\ResponseInterface;
use Moss\Storage\Schema\Schema;

class StorageController extends ConsoleController
{
    const EXECUTED = 'Executed';
    const PREVIEW = 'Preview';

    /** @var Schema */
    protected $schema;

    /**
     * Creates instance used in controller
     */
    public function before()
    {
        $this->schema = $this->app->get('schema');
    }

    /**
     * Builds message structure
     *
     * @param string $prefix
     * @param array  $queries
     *
     * @return string
     */
    protected function msg($prefix, array $queries)
    {
        $count = count($queries);
        if ($count == 0) {
            $queries[] = '---none---';
        }

        return PHP_EOL . $prefix . PHP_EOL . 'Queries: ' . $count . PHP_EOL . "\t - " . implode(PHP_EOL . "\t - ", $queries) . PHP_EOL;
    }

    /**
     * Lists queries needed to create missing database tables
     * Add --force parameter to execute them
     *
     * @return ResponseInterface
     */
    public function createAction()
    {
        $query = $this->schema->create();
        $result = $query->queryString();

        if ($this->app->request()->query()->get('force')) {
            $query->execute();

            return $this->response($this->msg(self::EXECUTED, $result));
        }

        return $this->response($this->msg(self::PREVIEW, $result));
    }

    /**
     * Lists queries needed to update tables - this also includes creation of non existing ones
     * Add --force parameter to execute them
     *
     * @return ResponseInterface
     */
    public function updateAction()
    {
        $query = $this->schema->alter();
        $result = $query->queryString();

        if ($this->app->request()->query()->get('force')) {
            $query->execute();

            return $this->response($this->msg(self::EXECUTED, $result));
        }

        return $this->response($this->msg(self::PREVIEW, $result));
    }

    /**
     * Lists queries needed to drop all tables
     * Add --force parameter to execute them
     *
     * @return ResponseInterface
     */
    public function dropAction()
    {
        $query = $this->schema->drop();
        $result = $query->queryString();

        if ($this->app->request()->query()->get('force')) {
            $query->execute();

            return $this->response($this->msg(self::EXECUTED, $result));
        }

        return $this->response($this->msg(self::PREVIEW, $result));
    }
}
