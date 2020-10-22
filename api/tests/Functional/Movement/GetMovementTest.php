<?php


namespace App\Tests\Functional\Movement;


use Symfony\Component\HttpFoundation\JsonResponse;

class GetMovementTest extends MovementTestBase
{
    public function testGetMovement(): void
    {
        $juliaMovementId = $this->getJuliaMovementId();

        self::$julia->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaMovementId));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaMovementId, $responseData['id']);
    }

    public function testGetGroupMovement(): void
    {
        $juliaGroupMovementId = $this->getJuliaGroupMovementId();

        self::$julia->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaGroupMovementId));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaGroupMovementId, $responseData['id']);
    }

    public function testGetAnotherUserMovement(): void
    {
        $juliaMovementId = $this->getJuliaMovementId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaMovementId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testGetAnotherGroupMovement(): void
    {
        $juliaGroupMovementId = $this->getJuliaGroupMovementId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaGroupMovementId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

}