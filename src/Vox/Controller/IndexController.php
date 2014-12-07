<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created 02.12.14
 */
namespace Vox\Controller;

use Moss\Http\Response\Response;

class IndexController extends BaseController {

    public function indexAction() {

        return new Response(__METHOD__);

    }

} 
