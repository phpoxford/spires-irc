<?php

namespace PHPOxford\SpiresIrc\Tests\Irc\Commands;

use PHPOxford\SpiresIrc\Irc\Commands\Command;
use PHPOxford\SpiresIrc\Irc\Message\Command as CommandInterface;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Command::command
     */
    public function implements_command_interface()
    {
        $command = new Command('PING', 'blah.freenode.com');

        assertThat($command, is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Command::command
     */
    public function can_get_the_command_string()
    {
        $command = new Command('PING', 'blah.freenode.com');

        assertThat($command->command(), is(identicalTo('PING')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Command::params
     */
    public function can_get_the_params_string()
    {
        $command = new Command('USER', 'guest 0 * :Ronnie Reagan');

        assertThat($command->params(), is(identicalTo('guest 0 * :Ronnie Reagan')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Command::raw
     */
    public function can_get_the_raw_command_without_params()
    {
        $command = new Command('QUIT');

        assertThat($command->raw(), is(identicalTo('QUIT')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Command::raw
     */
    public function can_get_the_raw_command_with_params()
    {
        $command = new Command('USER', 'guest 0 * :Ronnie Reagan');

        assertThat($command->raw(), is(identicalTo('USER guest 0 * :Ronnie Reagan')));
    }
}
