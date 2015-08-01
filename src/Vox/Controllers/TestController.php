<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created 02.12.14
 */
namespace Vox\Controllers;

use Moss\Http\Response\Response;

class TestController extends BaseController {

    public function indexAction() {

        return new Response('This is the test controller');

    }

} 
