<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserGroupsTest extends UserTestBase
{
    public function testGetUserGroups(): void
    {
        self::$julia->request('GET', sprintf('%s/%s/groups', $this->endpoint, $this->getJuliaId()));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(1, $responseData['hydra:member']);
    }

    public function testGetAnotherUserGroups(): void
    {
        self::$brian->request('GET', sprintf('%s/%s/groups', $this->endpoint, $this->getJuliaId()));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can\'t retrieve another user groups', $responseData['message']);
    }
}