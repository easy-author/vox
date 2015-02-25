<?php
namespace Console\Controller;

use Moss\Http\Response\Response;
use Moss\Http\Response\ResponseInterface;
use Moss\Storage\Schema\SchemaInterface;

class StorageController extends ConsoleController
{
    const EXECUTED = 'Executed';
    const PREVIEW = 'Preview';

    /**
     * Creates configuration file for database
     *
     * @return Response
     */
    public function configureAction()
    {
        $source = $this->app->get('path.app') . '/Vox/bootstrap.db.connection.sample.php';
        $target = $this->app->get('path.app') . '/Vox/bootstrap.db.connection.php';

        $vars = [
            'database' => true,
            'user' => true,
            'password' => false,
            'host' => true
        ];
        $reps = [];
        foreach ($vars as $var => $required) {
            if ($required && !$this->app->request()->query()->has($var)) {
                return $this->response(sprintf('Missing required configuration value "%s"', $var));
            }

            $reps['@'.$var.'@'] = $this->app->request()->query()->get($var);
        }

        $content = file_get_contents($source);
        $content = strtr($content, $reps);
        file_put_contents($target, $content, LOCK_EX);

        return $this->response('Configuration created');
    }

    /**
     * Lists queries needed to create missing database tables
     * Add --force parameter to execute them
     *
     * @return ResponseInterface
     */
    public function createAction()
    {
        $query = $this->getSchema()->create();
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
        $query = $this->getSchema()->alter();
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
        $query = $this->getSchema()->drop();
        $result = $query->queryString();

        if ($this->app->request()->query()->get('force')) {
            $query->execute();

            return $this->response($this->msg(self::EXECUTED, $result));
        }

        return $this->response($this->msg(self::PREVIEW, $result));
    }

    /**
     * Returns storage schema instance
     *
     * @return SchemaInterface
     */
    protected function getSchema()
    {
        return $this->app->get('schema');
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
}
