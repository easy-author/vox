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


abstract class AbstractNode
{

    protected $id;

    protected $left = 0;
    protected $right = 1;

    protected $parent_id = 0;
    protected $order = 0;

    /** @var array|AbstractNode[] */
    public $children = array();

    /**
     * Builds tree using parent_id & order properties
     *
     * @return $this
     */
    public function parentify()
    {
        $tArr = $this->gather(array($this->id => &$this), 'id');

        uasort(
            $tArr, function (self $a, self $b) {
            return $a->order - $b->order;
        }
        );

        $uArr = array();
        foreach ($tArr as $i => &$category) {
            if (!$category->id) {
                unset($category);
                continue;
            }

            if (isset($tArr[$category->parent_id])) {
                $tArr[$category->parent_id]->children[] = &$category;
                $uArr[] = $i;
            }

            unset($category);
        }

        foreach ($uArr as $i) {
            unset($tArr[$i]);
        }

        return $this;
    }

    /**
     * Builds tree using nested set left-right properties
     *
     * @return $this
     */
    public function nestify()
    {
        $tArr = $this->gather(array($this->left => $this), 'left');

        $lft = &$this->left;
        $rgt = &$this->right;

        uasort(
            $tArr, function (self $a, self $b) use (&$lft, &$rgt) {
            $lft = (int) min($lft, $a->left, $b->left);
            $rgt = (int) max($rgt, $a->right, $b->right);

            return $a->left - $b->left;
        }
        );

        $this->right++;

        $this->buildSet($this, $tArr);

        return $this;
    }

    /**
     * Builds set
     * Internal, used by nestify
     *
     * @param $parent
     * @param $tArr
     */
    protected function buildSet(&$parent, &$tArr)
    {
        $rArr = array();
        while ($category = array_shift($tArr)) {
            if ($category->left > $parent->left && $category->right < $parent->right) {
                $parent->children[] = $category;
            } else {
                $rArr[] = $category;
            }
        }

        $tArr = $rArr;

        foreach ($parent->children as $category) {
            $this->buildSet($category, $parent->children);
            unset($category);
        }
    }

    /**
     * Flattens tree to simple array as children in root node
     * Preserves all property values
     *
     * @return $this
     */
    public function flatten()
    {
        $this->children = $this->gather();

        return $this;
    }

    /**
     * Gathers nodes
     *
     * @param array       $tArr
     * @param null|string $key
     *
     * @return array
     */
    protected function gather($tArr = array(), $key = null)
    {
        foreach ($this->children as &$category) {
            if ($key) {
                $tArr[$category->$key] = &$category;
            } else {
                $tArr[] = &$category;
            }
            $tArr = $category->gather($tArr, $key);
            unset($category);
        }

        $this->children = array();

        return $tArr;
    }

    /**
     * Rebuilds properties in tree
     *
     * @param int $i
     * @param int $parent_id
     *
     * @return $this
     */
    public function rebuild(&$i = 0, $parent_id = 0)
    {
        $this->left = $i;

        foreach ($this->children as &$category) {

            $i++;

            $category->parent_id = $parent_id;
            $category->rebuild($i, $category->id);

            unset($category);
        }

        $this->right = ++$i;

        return $this;
    }
}
