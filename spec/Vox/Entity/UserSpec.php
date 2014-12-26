<?php

namespace spec\Vox\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Vox\Entity\User');
    }

    function let()
    {
        $this->beConstructedWith(1, 'test', ['admin'], ['read', 'write', 'delete']);
    }

    public function it_should_return_user_id() {
        $this->identify()->shouldReturn(1);
    }

    public function it_should_return_list_of_roles() {
        $this->getRoles()->shouldReturn(['admin']);
    }

    public function it_should_return_true_if_user_has_role() {
        $this->hasRole('admin')->shouldReturn(true);
        $this->hasRole('foo')->shouldReturn(false);
    }

    public function it_should_return_list_of_rights() {
        $this->getRights()->shouldReturn(['read', 'write', 'delete']);
    }

    public function it_should_return_true_if_user_has_right() {
        $this->hasRight('read')->shouldReturn(true);
        $this->hasRight('foo')->shouldReturn(false);
    }
}
