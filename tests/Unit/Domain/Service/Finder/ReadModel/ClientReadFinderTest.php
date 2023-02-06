<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service\Finder\ReadModel;

use App\Domain\Common\Specification\SpecificationInterface;
use App\Domain\Entity\Client;
use App\Domain\Exception\ClientException;
use App\Domain\Repository\ReadModel\ClientReadModelInterface;
use App\Domain\Service\Finder\ReadModel\ClientReadFinder;
use App\Domain\Specification\ClientSpecificationFactoryInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClientReadFinderTest extends TestCase implements ClientReadModelInterface, ClientSpecificationFactoryInterface
{
    protected ?Client $client;


    /**
     * @test
     */
    public function it_should_return_exception_when_not_found_client()
    {
        $this->expectException(ClientException::class);
        $this->client = null;

        $finder = new ClientReadFinder($this, $this);
        $finder->findOneOrFailByUuid(Uuid::uuid4());
    }


    /**
     * @test
     */
    public function it_should_return_one_client()
    {
        $this->client = m::mock(Client::class);

        $uuid   = Uuid::uuid4();
        $finder = new ClientReadFinder($this, $this);

        self::assertSame($this->client, $finder->findOneOrFailByUuid($uuid));
    }



    public function findOneOrNull(SpecificationInterface $specification): ?Client
    {
        return $this->client;
    }


    public function createForFindOneWithUuid(UuidInterface $uuid): SpecificationInterface
    {
        return m::mock(SpecificationInterface::class);
    }
}
