<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteGroupTest extends GroupTestBase
{
    public function testDeleteGroup(): void
    {
        self::$julia->request('DELETE', sprintf('%s/%s', $this->endpoint, $this->getJuliaGroupId()));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherGroup(): void
    {
        self::$brian->request('DELETE', sprintf('%s/%s', $this->endpoint, $this->getJuliaGroupId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}