<?php
namespace Vox\Router;

/*
* This file is part of the vox package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Moss\Http\Router\Route;

/**
 * Class DynamicRoute
 * Overloads Route and returns controller action from url as controller@action notation
 *
 * Usage:
 *     $router->register('dynamic', new \Vox\Router\DynamicRoute('/{controller}/({action})', null));
 * When calling /Foo_Bar/yada
 *     \Foo\BarController@yadaAction will be called
 * If no action - indexAction will be called
 *
 * @package Vox\Router
 */
class DynamicRoute extends Route
{
    /**
     * Returns controller
     *
     * @return string|callable
     */
    public function controller()
    {
        return sprintf(
            '%sController@%sAction',
            str_replace('_', '\\', $this->arguments['controller']),
            $this->arguments['action'] ?: 'index'
        );
    }
}
