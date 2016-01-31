<?php
declare(strict_types=1);

namespace JdhmApi\Tests\Unitary\Git\Hook;

use JdhmApi\Git\Hook\Hooks;

class HooksTest extends \PHPUnit_Framework_TestCase
{
    private $hooks;
    private $event;

    public function setUp()
    {

    }

    public function testCreate()
    {
        $event = $this->getMockBuilder('Composer\Script\Event')
                      ->disableOriginalConstructor()
                      ->getMock();

        $output = $this->getMockBuilder('Composer\IO\ConsoleIO')
                       ->disableOriginalConstructor()
                       ->getMock();

        $event->expects($this->any())
              ->method('getIO')
              ->willReturn($output);

        $output->expects($this->any())
               ->method('write')
               ->willReturn($this->returnArgument(0));

        $hooks = new Hooks();

        $test = $hooks->create($event);

        $this->assertTrue($test);
    }
}
