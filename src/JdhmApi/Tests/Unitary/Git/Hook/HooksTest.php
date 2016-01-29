<?php
//declare(strict_types=1);

namespace JdhmApi\Tests\Unitary\Git\Hook;

use JdhmApi\Git\Hook\Hooks;

class HooksTest extends \PHPUnit_Framework_TestCase
{
    private $hooks;
    private $event;

    public function setUp()
    {
        $event = $this->getMockBuilder('Composer\Script\Event')
                      ->getMock();

        $this->event = $event->expects($this->any())
                             ->method('getIO')
                             ->willReturn("nothing");

        $this->hooks = new Hooks();
    }

    public function testcreate()
    {
        $test = $this->hooks->create($this->event);

        var_dump($test);
        die;
        $this->assertInternalType('string', $test);
    }
}
