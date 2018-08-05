<?php

namespace Jevets\Kirby\Flash\Tests;

use Kirby\Cms\App;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Default preparation for each test.
     */
    public function setUp()
    {
        parent::setUp();
        App::instance(new SessionTestApp());
    }
}
