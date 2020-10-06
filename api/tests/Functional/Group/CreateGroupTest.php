<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class CreateGroupTest extends GroupTestBase
{
    public function testCreateGroup(): void
    {
        $payload = [
            'name' => 'My new group',
            'owner' => sprintf('/api/v1/users/%s', $this->getJuliaId()),
        ];

        self::$julia->request('POST', $this->endpoint, [], [], [], json_encode($payload));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testCreateGroupForAnotherUser(): void
    {
        $payload = [
            'name' => 'My new group',
            'owner' => sprintf('/api/v1/users/%s', $this->getJuliaId()),
        ];
        self::$brian->request('POST', $this->endpoint, [], [], [], json_encode($payload));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create groups fot another user', $responseData['message']);
    }
}