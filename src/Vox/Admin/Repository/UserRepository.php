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
use Moss\Storage\Query\StorageInterface;
use Vox\Entity\User;

class UserRepository
{
    const RANDOM_DOMAIN = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Constructor
     *
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Creates and returns new user instance
     *
     * @param int    $id
     * @param string $login
     * @param array  $roles
     * @param array  $rights
     *
     * @return User
     */
    public function create($id, $login, $roles = [], $rights = [])
    {
        return new User($id, $login, $roles, $rights);
    }

    /**
     * Returns user instance matching credentials
     * If not found or more than one instance found - returns false
     *
     * @param string $login
     * @param string $password
     *
     * @return UserInterface
     */
    public function getUserByCredentials($login, $password)
    {
        $query = $this->storage->readOne('user')->where('login', $login);
        if (!$query->count()) {
            return null;
        }

        $user = $query->execute();
        if (!$this->isPasswordValid($user, $password)) {
            return null;
        }

        return $user;
    }

    /**
     * Returns user instance matching token
     * If not found or more than one instance found - returns false
     *
     * @param TokenInterface $token
     *
     * @return UserInterface
     */
    public function getUserByToken(TokenInterface $token)
    {
        $query = $this->storage->readOne('user')->where('token', $token->authenticate());
        if (!$query->count()) {
            return null;
        }

        return $query->execute();
    }

    /**
     * Generates token string for set user
     * Associates user with that token
     *
     * @param User $user
     *
     * @return string
     */
    public function generateToken(User $user)
    {
        $token = $this->getRandomString(64);
        $user->setToken($token);
        $this->write($user);

        return $token;
    }

    /**
     * generate random string
     *
     * @param int    $length
     * @param string $chars
     *
     * @return string
     */
    public function getRandomString($length, $chars = self::RANDOM_DOMAIN)
    {
        $str = '';
        $domainLength = strlen($chars) - 1;

        while ($length-- >= 0) {
            $str .= $chars[mt_rand(0, $domainLength)];
        }

        return $str;
    }

    /**
     * Returns password hash
     *
     * @param string $password
     *
     * @return string
     */
    public function getHashedPassword($password)
    {
        return password_hash((string) $password, PASSWORD_DEFAULT);
    }

    /**
     * Returns true if password is valid
     *
     * @param User   $user
     * @param string $password
     *
     * @return bool
     */
    public function isPasswordValid(User $user, $password)
    {
        return password_verify($password, $user->getHash());
    }

    /**
     * Writes entity into database
     *
     * @param User $user
     *
     * @return bool
     */
    public function write(User $user)
    {
        $this->storage->write($user)->execute();

        return true;
    }
}
