<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use App\Domain\Entity\Client;
use App\Domain\ValueObj\ClientName;
use Ramsey\Uuid\UuidInterface;

class ClientWasCreated extends AbstractEvent
{
    /** @var UuidInterface */
    public $uuid;

    /** @var ClientName */
    public $name;


    /**
     * ClientWasCreated constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->uuid = $client->getUuid();
        $this->name = $client->getName();
    }


    /**
     * {@inheritdoc}
     */
    protected function index(): string
    {
        return $this->uuid->toString();
    }


    /**
     * {@inheritdoc}
     */
    protected function payload(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'name' => $this->name->toStr(),
        ];
    }
}
