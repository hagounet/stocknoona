<?php

namespace Noona\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NoonaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
