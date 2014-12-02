<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created 02.12.14
 */

namespace Vox\Controllers;

use Moss\Http\Response\Response;
use Moss\Kernel\AppInterface;

class BaseController {

    protected $app;

    public function __construct(AppInterface $app) {
        $this->app = $app;
    }

} 
