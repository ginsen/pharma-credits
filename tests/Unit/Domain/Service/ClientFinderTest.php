<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Service;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use App\Domain\Exception\ClientException;
use App\Domain\Repository\ClientReadModelInterface;
use App\Domain\Service\ClientFinder;
use App\Domain\Specification\ClientSpecificationFactoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Mockery as m;

class ClientFinderTest extends TestCase implements ClientReadModelInterface, ClientSpecificationFactoryInterface
{
    protected $client;


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_exception_when_not_found_client()
    {
        $this->expectException(ClientException::class);
        $this->client = null;

        $finder = new ClientFinder($this, $this);
        $finder->findOneOrFailByUuid(Uuid::uuid4());
    }


    /**
     * @test
     * @throws \Exception
     */
    public function it_should_return_one_client()
    {
        $this->client = m::mock(Client::class);

        $uuid = Uuid::uuid4();
        $finder = new ClientFinder($this, $this);

        self::assertSame($this->client, $finder->findOneOrFailByUuid($uuid));
    }



    public function getOneOrNull(SpecificationInterface $specification): ?Client
    {
        return $this->client;
    }


    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface
    {
        return m::mock(SpecificationInterface::class);
    }
}
