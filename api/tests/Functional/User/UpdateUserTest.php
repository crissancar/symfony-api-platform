<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateUserTest extends UserTestBase
{
    public function testUpdateUser(): void
    {
        $payload = ['name' => 'Julia New'];

        self::$julia->request(
            'PUT',
            sprintf('%s/%s', $this->endpoint, $this->getJuliaId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testUpdateAnotherUser(): void
    {
        $payload = ['name' => 'Julia New'];

        self::$roger->request(
            'PUT',
            sprintf('%s/%s', $this->endpoint, $this->getJuliaId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$roger->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

}