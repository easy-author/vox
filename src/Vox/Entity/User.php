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
    protected $hash;

    protected $token;

    protected $roles = [];
    protected $rights = [];

    public function __construct($id = null, $login = null, array $roles = [], array $rights = [])
    {
        if ($id !== null) {
            $this->id = $id;
        }

        if ($login !== null) {
            $this->login = $login;
        }

        if ($roles !== []) {
            $this->roles = $roles;
        }

        if ($rights !== []) {
            $this->rights = $rights;
        }
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
     * Sets password hash
     *
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = (string) $hash;
    }

    /**
     * Returns password hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Sets token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = (string) $token;
    }

    /**
     * Return token string
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
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
