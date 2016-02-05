<?php

namespace PHPOxford\SpiresIrc\Tests\Irc\Commands;

use PHPOxford\SpiresIrc\Irc\Commands\Privmsg;

class PrivmsgTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::command
     */
    public function can_get_the_command_string()
    {
        $command = new Privmsg('#phpoxford :+The lock file does my fucking head in');

        assertThat($command->command(), is(identicalTo('PRIVMSG')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::params
     */
    public function can_get_the_params_string()
    {
        $command = new Privmsg('#phpoxford :+The lock file does my fucking head in');

        assertThat($command->params(), is(identicalTo('#phpoxford :+The lock file does my fucking head in')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::params
     */
    public function can_get_the_target_string()
    {
        $command = new Privmsg('#phpoxford :+The lock file does my fucking head in');

        assertThat($command->target(), is(identicalTo('#phpoxford')));
    }

    /**
     * @test
     * @covers \PHPOxford\SpiresIrc\Irc\Commands\Privmsg::params
     */
    public function can_get_the_text_string()
    {
        $command = new Privmsg('#phpoxford :+The lock file does my fucking head in');

        assertThat($command->text(), is(identicalTo('+The lock file does my fucking head in')));
    }
}
