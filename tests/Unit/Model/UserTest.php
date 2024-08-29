<?php

use PHPUnit\Framework\TestCase;
use Model\User;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User(1, 'John Doe', 'john.doe@example.com', 'securepassword', true);
    }

    public function testUserCanBeCreated()
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->user->getId());
    }

    public function testSetId()
    {
        $this->user->setId(2);
        $this->assertEquals(2, $this->user->getId());
    }

    public function testGetName()
    {
        $this->assertEquals('John Doe', $this->user->getName());
    }

    public function testSetName()
    {
        $this->user->setName('Jane Doe');
        $this->assertEquals('Jane Doe', $this->user->getName());
    }

    public function testGetEmail()
    {
        $this->assertEquals('john.doe@example.com', $this->user->getEmail());
    }

    public function testSetEmail()
    {
        $this->user->setEmail('jane.doe@example.com');
        $this->assertEquals('jane.doe@example.com', $this->user->getEmail());
    }

    public function testGetPassword()
    {
        $this->assertEquals('securepassword', $this->user->getPassword());
    }

    public function testSetPassword()
    {
        $this->user->setPassword('newpassword');
        $this->assertEquals('newpassword', $this->user->getPassword());
    }

    public function testGetIsActive()
    {
        $this->assertTrue($this->user->getIsActive());
    }

    public function testSetIsActive()
    {
        $this->user->setIsActive(false);
        $this->assertFalse($this->user->getIsActive());
    }
}
