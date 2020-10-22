<?php


namespace App\Tests\Functional\Movement;


use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMovementTest extends MovementTestBase
{
    public function testDeleteMovement(): void
    {
        self::$julia->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getJuliaMovementId()));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteGroupMovement(): void
    {
        self::$julia->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getJuliaGroupMovementId()));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherUserMovement(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getJuliaMovementId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testDeleteAnotherGroupMovement(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getJuliaGroupMovementId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

}