<?php
namespace Console\Controller;

use Moss\Container\Container;
use Moss\Kernel\App;

class ConsoleController
{
    /** @var Container */
    protected $app;

    public function __construct(App $app)
    {
        $this->app = & $app;

        if ($this->app->request->method() !== 'CLI') {
            throw new \BadMethodCallException('Console controllers can be called only by command line (request method: CLI)');
        }
    }
}
