<?php

namespace spec\Vox\Admin\Model;

use Moss\Security\Token;
use Moss\Security\TokenInterface;
use Moss\Security\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vox\Admin\Repository\UserRepository;

class UserModelSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Vox\Admin\Model\UserModel');
    }

    function let(UserRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    public function it_should_not_support_any_other_credentials_sets()
    {
        $this->supportsCredentials([])->shouldReturn(false);
    }

    public function it_should_support_login_password_credentials()
    {
        $this->supportsCredentials(['login' => null, 'password' => null])->shouldReturn(true);
    }

    public function it_should_not_support_any_other_tokens(TokenInterface $token)
    {
        $this->supportsToken($token)->shouldReturn(false);
    }

    public function it_should_support_token(Token $token)
    {
        $this->supportsToken($token)->shouldReturn(true);
    }

    public function it_should_return_token_for_valid_credentials(UserRepository $repository, UserInterface $user, TokenInterface $token)
    {
        $repository->getUserByCredentials('test', 'test')->willReturn($user);
        $repository->generateToken($user)->willReturn($token);

        $this->tokenize(['login' => 'test', 'password' => 'test'])->shouldReturnAnInstanceOf('Moss\Security\TokenInterface');
    }

    public function it_should_authenticate_token(UserRepository $repository, UserInterface $user, TokenInterface $token)
    {
        $token->isAuthenticated()->willReturn(true);

        $repository->getUserByToken($token)->willReturn($user);

        $this->authenticate($token)->shouldReturn(true);
    }

    public function it_should_return_user(UserRepository $repository, UserInterface $user, TokenInterface $token)
    {
        $repository->getUserByToken($token)->willReturn($user);

        $this->get($token)->shouldReturn($user);
    }
}
