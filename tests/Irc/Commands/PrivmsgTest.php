<?php

namespace PHPOxford\SpiresIrc\Tests\Irc\Commands;

use PHPOxford\SpiresIrc\Irc\Commands\Privmsg;
use PHPOxford\SpiresIrc\Irc\Message\Command as CommandInterface;

class PrivmsgTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg
     */
    public function implements_command_interface()
    {
        $command = new Privmsg(['#phpoxford'], 'The lock file does my fucking head in');

        assertThat($command, is(anInstanceOf(CommandInterface::class)));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::command
     */
    public function can_get_the_command_string()
    {
        $command = new Privmsg(['#phpoxford'], 'The lock file does my fucking head in');

        assertThat($command->command(), is(identicalTo('PRIVMSG')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::targets
     */
    public function can_get_the_targets()
    {
        $command = new Privmsg(['#phpoxford', '#phpoxfordgames'], 'The lock file does my fucking head in');

        assertThat($command->targets(), is(identicalTo(['#phpoxford', '#phpoxfordgames'])));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::text
     */
    public function can_get_the_text()
    {
        $command = new Privmsg(['#phpoxford'], 'The lock file does my fucking head in');

        assertThat($command->text(), is(identicalTo('The lock file does my fucking head in')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::params
     */
    public function can_get_params_with_one_target()
    {
        $command = new Privmsg(['#phpoxford'], 'The lock file does my fucking head in');

        assertThat($command->params(), is(identicalTo('#phpoxford :The lock file does my fucking head in')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::params
     */
    public function can_get_params_with_two_targets()
    {
        $command = new Privmsg(['#phpoxford', '#phpoxfordgames'], 'The lock file does my fucking head in');

        assertThat($command->params(), is(identicalTo('#phpoxford,#phpoxfordgames :The lock file does my fucking head in')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::__toString
     */
    public function can_cast_to_string_with_one_target()
    {
        $command = new Privmsg(['#phpoxford'], 'The lock file does my fucking head in');

        assertThat((string) $command, is(identicalTo('PRIVMSG #phpoxford :The lock file does my fucking head in')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::__toString
     */
    public function can_cast_to_string_with_two_targets()
    {
        $command = new Privmsg(['#phpoxford', '#phpoxfordgames'], 'The lock file does my fucking head in');

        assertThat((string) $command, is(identicalTo('PRIVMSG #phpoxford,#phpoxfordgames :The lock file does my fucking head in')));
    }

}
