<?php

namespace App\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestBase extends WebTestCase
{
    use FixturesTrait;
    use RecreateDatabaseTrait;

    protected static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $julia = null;
    protected static ?KernelBrowser $brian = null;
    protected static ?KernelBrowser $roger = null;

    protected function setUp(): void
    {
        if (null === self::$client) {
            self::$client = static::createClient();
            self::$client->setServerParameters(
                [
                    'CONTENT_TYPE' => 'application/json',
                    'HTTP_ACCEPT' => 'application/ld+json',
                ]
            );
        }

        if (null === self::$julia) {
            self::$julia = clone self::$client;
            $this->createAuthenticatedUser(self::$julia, 'julia@api.com');
        }

        if (null === self::$brian) {
            self::$brian = clone self::$client;
            $this->createAuthenticatedUser(self::$brian, 'brian@api.com');
        }

        if (null === self::$roger) {
            self::$roger = clone self::$client;
            $this->createAuthenticatedUser(self::$roger, 'roger@api.com');
        }
    }

    private function createAuthenticatedUser(KernelBrowser &$client, string $email): void
    {
        $user = $this->getContainer()->get('App\Repository\UserRepository')->findOneByEmailOrFail($email);
        $token = $this
            ->getContainer()
            ->get('Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface')
            ->create($user);

        $client->setServerParameters(
            [
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/ld+json',
            ]
        );
    }

    protected function getResponseData(Response $response): array
    {
        return \json_decode($response->getContent(), true);
    }

    protected function initDbConnection(): Connection
    {
        return $this->getContainer()->get('doctrine')->getConnection();
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getJuliaId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "julia@api.com"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user WHERE email = "brian@api.com"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getBrianGroupId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user_group WHERE name = "Brian Group"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getJuliaGroupId()
    {
        return $this->initDbConnection()->query('SELECT id FROM user_group WHERE name = "Julia Group"')->fetchColumn(0);
    }


}
