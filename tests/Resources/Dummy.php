<?php

namespace Antares\Foundation\Tests\Resources;

class Dummy
{
    public $publicVar = 'public content';

    public function getPublicVar()
    {
        return $this->publicVar;
    }

    protected $protectedVar = 'protected content';

    public function getProtectedVar()
    {
        return $this->protectedVar;
    }

    private $privateVar = 'private content';

    public function getPrivateVar()
    {
        return $this->privateVar;
    }
}
