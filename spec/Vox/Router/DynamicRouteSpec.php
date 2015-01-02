<?php

namespace spec\Vox\Router;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DynamicRouteSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('', '');
        $this->shouldHaveType('Vox\Router\DynamicRoute');
    }

    public function it_should_return_controller_action_call_string()
    {
        $this->beConstructedWith('/foo/{controller}/{action}', '\\Namespace\\Foo\\{controller}Controller@{action}Action');
        $this->arguments(['controller' => 'Bar', 'action' => 'yada']);

        $this->controller()->shouldReturn('\\Namespace\Foo\BarController@yadaAction');
    }

    public function it_should_return_controller_with_index_action_call_when_no_action_provided()
    {
        $this->beConstructedWith('/foo/{controller}/{action}', '\\Namespace\\Foo\\{controller}Controller@{action}Action');
        $this->arguments(['controller' => 'Bar']);

        $this->controller()->shouldReturn('\\Namespace\Foo\BarController@indexAction');
    }

    public function it_should_throw_exception_when_controller_is_missing_in_arguments()
    {
        $this->beConstructedWith('/foo/{controller}/{action}', '\\Namespace\\Foo\\{controller}Controller@{action}Action');
        $this->shouldThrow('\Moss\Http\Router\RouteException')->during('make', ['', []]);
    }

    public function it_should_return_url_matching_pattern()
    {
        $this->beConstructedWith('/foo/{controller}/{action}', '\\Namespace\\Foo\\{controller}Controller@{action}Action');
        $this->make('localhost', ['controller' => 'Bar', 'action' => 'yada'])->shouldReturn('http://localhost/foo/Bar/yada');
    }
}
