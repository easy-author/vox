<?php

namespace spec\Vox\Admin\Repository;

use Moss\Security\TokenInterface;
use Moss\Storage\Query\ReadQueryInterface;
use Moss\Storage\Query\StorageInterface;
use Moss\Storage\Query\WriteQueryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vox\Admin\Repository\UserRepository;
use Vox\Entity\User;

class UserRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Vox\Admin\Repository\UserRepository');
    }

    function let(StorageInterface $storage)
    {
        $this->beConstructedWith($storage);
    }

    public function it_should_create_instance()
    {
        $this->create('foo', 'bar')->shouldBeAnInstanceOf('\Vox\Entity\User');
    }

    public function it_should_return_false_for_invalid_credentials(StorageInterface $storage, ReadQueryInterface $query)
    {
        $storage->readOne('user')->willReturn($query);

        $query->where('login', 'foo')->willReturn($query);
        $query->count()->willReturn(0);

        $this->getUserByCredentials('foo', 'bar')->shouldReturn(false);
    }

    public function it_should_return_user_instance_if_valid_credentials_passed(StorageInterface $storage, ReadQueryInterface $query, User $user)
    {
        $storage->readOne('user')->willReturn($query);

        $query->where('login', 'test')->willReturn($query);
        $query->count()->willReturn(1);
        $query->execute()->willReturn($user);

        $user->getHash()->willReturn($this->getHashedPassword('test'));

        $this->getUserByCredentials('test', 'test')->shouldReturnAnInstanceOf('Vox\Entity\User');
    }

    public function it_should_return_false_for_invalid_token(StorageInterface $storage, ReadQueryInterface $query, TokenInterface $token)
    {
        $storage->readOne('user')->willReturn($query);

        $query->where('token', 'HashedTokenString')->willReturn($query);
        $query->count()->willReturn(0);

        $token->authenticate()->willReturn('HashedTokenString');

        $this->getUserByToken($token)->shouldReturn(false);
    }

    public function it_should_return_user_instance_if_valid_token_provided(StorageInterface $storage, ReadQueryInterface $query, User $user, TokenInterface $token)
    {
        $storage->readOne('user')->willReturn($query);

        $query->where('token', 'HashedTokenString')->willReturn($query);
        $query->count()->willReturn(1);
        $query->execute()->willReturn($user);

        $token->authenticate()->willReturn('HashedTokenString');

        $this->getUserByToken($token)->shouldReturnAnInstanceOf('Vox\Entity\User');
    }

    public function it_should_generate_token_for_set_user(StorageInterface $storage, WriteQueryInterface $query, User $user)
    {
        $storage->write($user)->willReturn($query);

        $query->execute()->willReturn(true);

        $this->generateToken($user)->shouldMatch('/['.UserRepository::RANDOM_DOMAIN.']{64}/');
    }
}
