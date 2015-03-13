<?php
/**
 * @author  Marco Troisi <hello@marcotroisi.com>
 * @created 02.12.14
 */

namespace Vox\Admin\Controller;

use Moss\Http\Response\Response;
use Moss\Http\Response\ResponseRedirect;
use Moss\Kernel\AppInterface;

class BaseController
{

    protected $app;
    protected $security;
    protected $flashbag;
    protected $view;

    public function __construct(AppInterface $app)
    {
        $this->app = $app;
        $this->security = $this->app->get('security');
        $this->flashbag = $this->app->get('flashbag');
        $this->view = $this->app->get('view');
    }

    public function indexAction()
    {
        $this->view->template('Vox:Admin:index');

        return new Response($this->view->render());
    }

    public function loginAction()
    {
        $this->view->template('Vox:Admin:login');

        return new Response($this->view->render());
    }

    public function authAction()
    {
        try {
            $this->security->tokenize(
                [
                    'login' => $this->app->request()->body()->get('login'),
                    'password' => $this->app->request()->body()->get('password')
                ]
            );

            $this->security->authenticate($this->app->request());

            return new ResponseRedirect($this->app->router()->make('admin'));

        } catch (\Exception $e) {
            $this->flashbag->add($e->getMessage(), 'danger');

            return $this->loginAction();
        }
    }

    public function logoutAction()
    {
        $this->security->destroy();

        return new ResponseRedirect($this->app->router()->make('admin'));
    }
} 
