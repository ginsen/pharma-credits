<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Event\Event;

use App\Domain\Entity\Client;
use App\Domain\Event\Common\EventInterface;
use App\Domain\Event\Event\ClientWasCreated;
use App\Domain\ValueObj\ClientName;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ClientWasCreatedTest extends TestCase
{
    /** @var Client */
    protected static $client;


    /**
     * {@inheritdoc}
     * @throws \Exception|\Assert\AssertionFailedException
     */
    public static function setUpBeforeClass()
    {
        self::$client = self::getClient();
    }


    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass()
    {
        self::$client = null;
    }


    /**
     * @test
     */
    public function it_should_event_instance()
    {
        $event = new ClientWasCreated(self::$client);
        self::assertInstanceOf(EventInterface::class, $event);
    }


    /**
     * @test
     */
    public function it_should_serializable()
    {
        $event = new ClientWasCreated(self::$client);
        self::assertIsString($event->serialize());
    }


    /**
     * @throws \Exception|\Assert\AssertionFailedException
     * @return Client
     */
    protected static function getClient(): Client
    {
        return Client::create(Uuid::uuid4(), ClientName::fromStr('client'));
    }
}
