<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupTest extends GroupTestBase
{
    public function testGetGroup(): void
    {
        $juliaGroupId = $this->getJuliaGroupId();

        self::$julia->request('GET', sprintf('%s/%s', $this->endpoint, $juliaGroupId));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaGroupId, $responseData['id']);
    }

    public function testGetAnotherGroupData(): void
    {
        $juliaGroupId = $this->getJuliaGroupId();
        $juliaId = $this->getJuliaId();
        $brianId = $this->getBrianId();
        $brianGroupId = $this->getBrianGroupId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaGroupId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}