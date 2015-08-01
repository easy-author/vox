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


class Navigation
{
    /**
     * @var Category
     */
    protected $root;

    /**
     * @param Category[] $categories
     */
    public function __construct(array $categories = [])
    {
        $this->root = new Category('root');
        $this->root->identify(0);

        foreach ($categories as $category) {
            list($title, $route, $parentIdentifier) = (array) $category + [null, null, 0];
            $this->register($title, $route, $parentIdentifier);
        }
    }

    /**
     * Add category to tree
     *
     * @param string $title
     * @param string $route
     * @param int $parentIdentifier
     */
    public function register($title, $route = null, $parentIdentifier = 0)
    {
        $category = new Category($title, $route, (int) $parentIdentifier);
        $category->identify(md5($title));
        $category->order(count($this->root->children));

        $this->root->children[] = $category;
    }

    public function build()
    {
        $struct = clone $this->root;
        $struct->parentify();

        return $struct->children;
    }
}
