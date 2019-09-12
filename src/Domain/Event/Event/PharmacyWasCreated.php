<?php

declare(strict_types=1);

namespace App\Domain\Event\Event;

use App\Domain\Entity\Pharmacy;
use App\Domain\ValueObj\PharmacyName;
use Ramsey\Uuid\UuidInterface;

class PharmacyWasCreated extends AbstractEvent
{
    /** @var UuidInterface */
    public $uuid;

    /** @var PharmacyName */
    public $name;


    /**
     * PharmacyWasCreated constructor.
     * @param Pharmacy $pharmacy
     */
    public function __construct(Pharmacy $pharmacy)
    {
        parent::__construct();

        $this->uuid = $pharmacy->getUuid();
        $this->name = $pharmacy->getName();
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
