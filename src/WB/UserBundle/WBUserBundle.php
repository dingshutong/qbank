<?php

namespace WB\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WBUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
