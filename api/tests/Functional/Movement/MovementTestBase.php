<?php


namespace App\Tests\Functional\Movement;


use App\Tests\Functional\TestBase;

class MovementTestBase extends TestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/movements';
    }
}