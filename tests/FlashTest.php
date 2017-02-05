<?php

namespace Jevets\Kirby\Flash\Tests;

use Jevets\Kirby\Flash;

class FlashTest extends TestCase
{

    public function testGetInstance()
    {
        $flash = Flash::getInstance();
        $this->assertInstanceof(Flash::class, $flash);
    }

    public function testSessionKey()
    {
        $this->assertEquals('_flash', Flash::sessionKey());
    }

    public function testSetSessionKey()
    {
        Flash::setSessionKey('_myflash');
        $this->assertEquals('_myflash', Flash::sessionKey());
    }

    public function testSetGetAll()
    {
        Flash::set('key', 'value');
        $this->assertEquals('value', Flash::get('key'));
        $this->assertEquals('default', Flash::get('key2', 'default'));
        $this->assertNull(Flash::get('key3'));
        $this->assertEquals(['key' => 'value'], Flash::all());
    }
}
