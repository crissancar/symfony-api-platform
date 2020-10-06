<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserTest extends UserTestBase
{
    public function testGetUser(): void
    {
        $juliaId = $this->getJuliaId();

        self::$julia->request('GET', sprintf('%s/%s', $this->endpoint, $juliaId));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaId, $responseData['id']);
        $this->assertEquals('julia@api.com', $responseData['email']);
    }

    public function testGetAnotherUserData(): void
    {
        $juliaId = $this->getJuliaId();

        self::$roger->request('GET', sprintf('%s/%s', $this->endpoint, $juliaId));

        $response = self::$roger->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}