<?php


namespace App\Tests\Functional\Movement;


use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateMovementTest extends MovementTestBase
{
    public function testUpdateMovement(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getJuliaExpenseCategoryId()),
            'amount' => 500.05,
        ];

        self::$julia->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getJuliaMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['category'], $responseData['category']['@id']);
        $this->assertEquals($payload['amount'], $responseData['amount']);
    }

    public function testUpdateAnotherUserMovement(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getJuliaExpenseCategoryId()),
            'amount' => 500.05,
        ];

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getJuliaMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testUpdateAnotherGroupMovement(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getJuliaExpenseCategoryId()),
            'amount' => 500.05,
        ];

        self::$julia->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getBrianGroupMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testUpdateMovementWithAnotherUserCategory(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getBrianExpenseCategoryId()),
            'amount' => 500.05,
        ];

        self::$julia->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getJuliaMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testUpdateMovementWithAnotherGroupCategory(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getBrianGroupExpenseCategoryId()),
            'amount' => 500.05,
        ];

        self::$julia->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getJuliaMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}