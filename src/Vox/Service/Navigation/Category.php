<?php

/*
* This file is part of the vox package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Vox\Service\Navigation;


class Category extends AbstractNode
{
    protected $title;
    protected $route;

    /**
     * Constructor
     *
     * @param string               $title
     * @param string               $route
     * @param int                  $parentIdentifier
     */
    public function __construct($title, $route = null, $parentIdentifier = 0)
    {
        $this->title = $title;
        $this->route = $route;
        $this->parent_id = $parentIdentifier;
    }

    /**
     * Return category identifier
     *
     * @param int $identifier
     *
     * @return int
     */
    public function identify($identifier = null)
    {
        if ($identifier !== null) {
            $this->id = $identifier;
        }

        return $this->id;
    }

    /**
     * Return title
     *
     * @param string $title
     *
     * @return string
     */
    public function title($title = null)
    {
        if ($title !== null) {
            $this->title = $title;
        }

        return $this->title;
    }

    /**
     * Return route name
     *
     * @param string $route
     *
     * @return string
     */
    public function route($route = null)
    {
        if ($route !== null) {
            $this->route = $route;
        }

        return $this->route;
    }

    /**
     * Return parent identifier
     *
     * @param int $parentIdentifier
     *
     * @return int
     */
    public function parent($parentIdentifier = null)
    {
        if ($parentIdentifier !== null) {
            $this->parent_id = $parentIdentifier;
        }

        return $this->parent_id;
    }

    /**
     * Set category order
     *
     * @param int $order
     *
     * @return int
     */
    public function order($order = null)
    {
        if($order !== null) {
            $this->order = (int) $order;
        }

        return (int) $this->order;
    }
}
