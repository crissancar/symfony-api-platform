<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupMovementTest extends GroupTestBase
{
    public function testGetGroupMovements(): void
    {
        self::$julia->request('GET', \sprintf('%s/%s/movements', $this->endpoint, $this->getJuliaGroupId()));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(1, $responseData['hydra:member']);
    }

    public function testGetAnotherGroupMovements(): void
    {
        self::$brian->request('GET', \sprintf('%s/%s/movements', $this->endpoint, $this->getJuliaGroupId()));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }
}