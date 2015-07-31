<?php
/**
 * @author  Marco Troisi <hello@marcotroisi.com>
 * @created 02.12.14
 */

namespace Vox\Admin\Controller;

use Moss\Http\Response\Response;
use Moss\Http\Response\ResponseRedirect;
use Moss\Kernel\AppInterface;

class PostController
{

    protected $app;
    protected $security;
    protected $flashbag;
    protected $view;
    protected $request;

    public function __construct(AppInterface $app)
    {
        $this->app = $app;
        $this->request = $this->app->request();
        $this->security = $this->app->get('security');
        $this->flashbag = $this->app->get('flashbag');
        $this->view = $this->app->get('view');
    }

    public function indexAction()
    {
        echo "test";
    }

    public function editAction()
    {
        $this->view->set('post_id', $this->request->query()->get('id'));

        $this->view->template('Vox:Admin:Post:edit');

        return new Response($this->view->render());
    }

    /**
     * Returns list of Posts
     *
     * @return Response
     */
    public function listAction()
    {
        return new Response(
            json_encode([
                [
                    'id' => 1,
                    'title' => 'First Post on Vox',
                    'author' => 'Mario Rossi',
                    'author_id' => 1,
                    'excerpt' => "Here we are! Finally this is my first post on Vox and I am so happy that...",
                    'content' => "Here we are! Finally this is my first post on Vox and I am so happy that this is my lorem ipsum bla bla bla bla!",
                    'date' => "08/01/2015"
                ],
                [
                    'id' => 2,
                    'title' => 'And yes, this is my second post!',
                    'author' => 'Lukas Schneider',
                    'author_id' => 2,
                    'excerpt' => "Well this is already my second post and so you already know that...",
                    'content' => "Well this is already my second post and so you already know that, in terms of being my second post,
                    this is exactly what is says it is: my second, incredibly well written and fantastimagically published post!",
                    'date' => "09/02/2015"
                ]
            ]),
            200,
            'application/json'
        );
    }

    public function getAction()
    {
        $id = $this->request->query()->get('id');

        return new Response(
            json_encode([
                'id' => 1,
                'title' => 'First Post on Vox',
                'author' => 'Mario Rossi',
                'author_id' => 1,
                'excerpt' => "Here we are! Finally this is my first post on Vox and I am so happy that...",
                'content' => "Here we are! Finally this is my first post on Vox and I am so happy that this is my lorem ipsum bla bla bla bla!",
                'date' => "08/01/2015"
            ]),
            200,
            'application/json'
        );
    }

} 
