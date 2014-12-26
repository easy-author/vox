<?php
namespace Vox\Entity;

use Moss\Security\UserInterface;

/*
* This file is part of the vox package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

class User implements UserInterface
{

    protected $id;
    protected $login;

    protected $roles = [];
    protected $rights = [];

    public function __construct($id, $login, array $roles = [], array $rights = [])
    {
        $this->id = (int)$id;
        $this->login = $login;
        $this->roles = $roles;
        $this->rights = $rights;
    }

    /**
     * Returns user identifier
     *
     * @return int|string
     */
    public function identify()
    {
        return $this->id;
    }

    /**
     * Returns all roles as an array
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns true if user has role
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }

    /**
     * Returns all role access as an array
     *
     * @return array
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * Returns true if user has access
     *
     * @param string $right
     *
     * @return bool
     */
    public function hasRight($right)
    {
        return in_array($right, $this->rights);
    }
}
