<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class UpdatedGroupTest extends GroupTestBase
{
    public function testUpdateGroup(): void
    {
        $payload = ['name' => 'New Group name'];

        self::$julia->request('PUT', sprintf('%s/%s', $this->endpoint, $this->getJuliaGroupId()),
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

    public function testUpdateAnotherGroup(): void
    {
        $payload = ['name' => 'New Group name'];

        self::$brian->request('PUT', sprintf('%s/%s', $this->endpoint, $this->getJuliaGroupId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}