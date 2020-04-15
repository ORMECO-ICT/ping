<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\PingCommand;
use PHPUnit\Framework\TestCase;

class PingCommandTest extends TestCase
{
    const HOST = '127.0.0.1';

    const COUNT = 10;

    const INTERVAL = 0.5;

    const SIZE = 128;

    const TIMEOUT = 2;

    const TTL = 128;

    /** @test */
    public function isPingCommandClass()
    {
        $command = PingCommand::Create(self::HOST);

        $this->assertInstanceOf(PingCommand::class, $command);
    }

    /** @test */
    public function canGetLinuxCommand()
    {
        $command = PingCommand::Create(self::HOST)->LinuxCommand();

        $this->assertStringContainsString(self::HOST, $command);
    }

    /** @test */
    public function canGetWindowsCommand()
    {
        $command = PingCommand::Create(self::HOST)->WindowsCommand();

        $this->assertStringContainsString(self::HOST, $command);
    }

    /** @test */
    public function canChangeCount()
    {
        $command = PingCommand::Create(self::HOST)->Count(self::COUNT);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
            $this->assertStringContainsString('-n '.self::COUNT, $command->WindowsCommand());
        } else {
            $this->assertStringContainsString('-c '.self::COUNT, $command->LinuxCommand());
        }
    }

    /** @test */
    public function canChangeInterval()
    {
        $command = PingCommand::Create(self::HOST)->Interval(self::INTERVAL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
            // AssertTrue because no interval can defined in windows ping
            $this->assertTrue(true);
        } else {
            $this->assertStringContainsString('-i '.self::INTERVAL, $command->LinuxCommand());
        }
    }

    /** @test */
    public function canChangePacketSize()
    {
        $command = PingCommand::Create(self::HOST)->PacketSize(self::SIZE);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
            $this->assertStringContainsString('-l '.self::SIZE, $command->WindowsCommand());
        } else {
            $this->assertStringContainsString('-s '.self::SIZE, $command->LinuxCommand());
        }
    }

    /** @test */
    public function canChangeTimeout()
    {
        $command = PingCommand::Create(self::HOST)->Timeout(self::TIMEOUT);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
            $this->assertStringContainsString('-w '.self::TIMEOUT, $command->WindowsCommand());
        } else {
            $this->assertStringContainsString('-W '.self::TIMEOUT, $command->LinuxCommand());
        }
    }

    /** @test */
    public function canChangeTimeToLive()
    {
        $command = PingCommand::Create(self::HOST)->TimeToLive(self::TTL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
            $this->assertStringContainsString('-i '.self::TTL, $command->WindowsCommand());
        } else {
            $this->assertStringContainsString('-t '.self::TTL, $command->LinuxCommand());
        }
    }
}
