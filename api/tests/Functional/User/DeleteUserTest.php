<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserTest extends UserTestBase
{
    public function testDeleteUser(): void
    {
        self::$julia->request('DELETE', sprintf('%s/%s', $this->endpoint, $this->getJuliaId()));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherUser(): void
    {
        self::$roger->request('DELETE', sprintf('%s/%s', $this->endpoint, $this->getJuliaId()));

        $response = self::$roger->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}