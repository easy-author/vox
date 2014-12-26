<?php
namespace Vox\Admin\Repository;

/*
* This file is part of the vox package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Moss\Security\TokenInterface;
use Moss\Security\UserInterface;
use Vox\Admin\Entity\User;

class UserRepository
{
    private $fakeTokenString = 'HashedTokenString';

    private function createFakeUser()
    {
        return new User(1, 'test');
    }

    /**
     * Returns user instance matching credentials
     * If not found or more than one instance found - returns false
     *
     * @param string $login
     * @param string $password
     *
     * @return bool|UserInterface
     */
    public function getUserByCredentials($login, $password)
    {
        if($login !== 'test' || $password !== 'test') {
            return false;
        }

        return $this->createFakeUser();
    }

    /**
     * Returns user instance matching token
     * If not found or more than one instance found - returns false
     *
     * @param TokenInterface $token
     *
     * @return bool|UserInterface
     */
    public function getUserByToken(TokenInterface $token)
    {
        if($token->authenticate() !== $this->fakeTokenString) {
            return false;
        }

        return $this->createFakeUser();
    }

    /**
     * Generates token string for set user
     * Associates user with that token
     *
     * @param UserInterface $user
     *
     * @return string
     */
    public function generateToken(UserInterface $user)
    {
        return $this->fakeTokenString;
    }
}
