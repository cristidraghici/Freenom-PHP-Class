<?php
namespace Freenom\Tests;

use Freenom\FreenomV2;
use PHPUnit\Framework\TestCase;

class FreenomV2Test extends TestCase
{
    public function testPing()
    {
        $freenom = new FreenomV2('', '', 1);
        $output = $freenom->ping([
            '__FILE__' => __FILE__,
            '__LINE__' => __LINE__,
        ]);

        $this->assertArrayHasKey('timestamp', $output);
        $this->assertArraySubset([
            'status' => 'OK',
            'result' => 'PING REPLY',
        ], $output);
    }

    public function testContactListOnNonResellerAccount()
    {
        $freenom = new FreenomV2('john@smith.net', '68bb651cb1', 1);
        $output = $freenom->contactList([
            '__FILE__' => __FILE__,
            '__LINE__' => __LINE__,
            'email' => 'john@smith.net',
            'password' => '68bb651cb1',
        ]);

        $this->assertArraySubset([
            'status' => 'error',
            'error' => 'Login credentials do not match any account',
        ], $output);
    }

    public function testDomainRegister()
    {
        $freenom = new FreenomV2('john@smith.net', '68bb651cb1', 1);
        $output = $freenom->domainRegister([
            '__FILE__' => __FILE__,
            '__LINE__' => __LINE__,
            'email' => 'john@smith.net',
            'password' => '68bb651cb1',
            'domainname' => 'domainname.tk',
            'owner_id' => 'owner_id',
        ]);

        $this->assertArraySubset([
            'error' => 'Login credentials do not match any account',
            'status' => 'error',
        ], $output);
    }
}
