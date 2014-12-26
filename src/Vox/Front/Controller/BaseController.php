<?php
namespace Vox\Front\Controller;

use Moss\Http\Response\Response;
use Moss\Kernel\AppInterface;

class BaseController
{

    protected $app;
    protected $security;
    protected $view;

    public function __construct(AppInterface $app)
    {
        $this->app = $app;
        $this->security = $this->app->get('security');
        $this->view = $this->app->get('view');
    }

    public function indexAction()
    {
        return new Response('Hoppla!');
    }
} 
