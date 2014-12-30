<?php

namespace spec\Vox\Admin\Repository;

use Moss\Security\TokenInterface;
use Moss\Security\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Vox\Admin\Repository\UserRepository');
    }

    public function it_should_return_false_for_invalid_credentials()
    {
        $this->getUserByCredentials('foo', 'bar')->shouldReturn(false);
    }

    public function it_should_return_user_instance_if_valid_credentials_passed()
    {
        $this->getUserByCredentials('test', 'test')->shouldReturnAnInstanceOf('Vox\Entity\User');
    }

    public function it_should_return_false_for_invalid_token(TokenInterface $token)
    {
        $token->authenticate()->willReturn('FooBar');

        $this->getUserByToken($token)->shouldReturn(false);
    }

    public function it_should_return_user_instance_if_valid_token_provided(TokenInterface $token)
    {
        $token->authenticate()->willReturn('HashedTokenString');

        $this->getUserByToken($token)->shouldReturnAnInstanceOf('Vox\Entity\User');
    }

    public function it_should_generate_token_for_set_user(UserInterface $user)
    {
        $this->generateToken($user)->shouldReturn('HashedTokenString');
    }
}
