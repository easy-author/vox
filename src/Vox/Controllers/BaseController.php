<?php
/**
 * @author Marco Troisi <marco.troisi@rocket-internet.de>
 * @copyright Copyright (c) 2014 Rocket Internet GmbH, Johannistraße 20, 10117 Berlin, http://www.rocket-internet.de
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
