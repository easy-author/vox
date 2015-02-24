<?php
namespace Vox\Admin\Model;

/*
* This file is part of the vox package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Moss\Security\Token;
use Moss\Security\UserProviderInterface;
use Moss\Security\UserInterface;
use Moss\Security\TokenInterface;
use Vox\Admin\Repository\UserRepository;

class UserModel implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns true if provider can handle credentials
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function supportsCredentials(array $credentials)
    {
        return ['login', 'password'] === array_keys($credentials);
    }

    /**
     * Creates token from credentials
     *
     * @param array $credentials
     *
     * @return TokenInterface
     */
    public function tokenize(array $credentials)
    {
        if (!$this->supportsCredentials($credentials)) {
            return false;
        }

        if (!$user = $this->repository->getUserByCredentials($credentials['login'], $credentials['password'])) {
            return false;
        }

        $tokenString = $this->repository->generateToken($user);

        return new Token($tokenString, $user->identify());
    }

    /**
     * Returns true if provider can handle token
     *
     * @param TokenInterface $token
     *
     * @return bool
     */
    public function supportsToken(TokenInterface $token)
    {
        return $token instanceof Token;
    }

    /**
     * Authenticates token in provider
     *
     * @param TokenInterface $token
     *
     * @return bool
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$token->isAuthenticated()) {
            return false;
        }

        if (!$this->repository->getUserByToken($token)) {
            return false;
        }

        return true;
    }

    /**
     * Returns user instance matching token
     *
     * @param TokenInterface $token
     *
     * @return UserInterface
     */
    public function get(TokenInterface $token)
    {
        return $this->repository->getUserByToken($token);
    }
}
