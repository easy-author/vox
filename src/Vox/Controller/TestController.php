<?php
/**
 * @author  Marco Troisi <hello@marcotroisi.com>
 * @created 02.12.14
 */
namespace Vox\Controller;

use Moss\Http\Response\Response;

class TestController extends BaseController
{

    public function indexAction()
    {
        return new Response(__METHOD__);
    }

    public function testAction()
    {
        return new Response(__METHOD__);
    }
}
