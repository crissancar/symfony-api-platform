<?php


namespace App\Tests\Functional\Group;


use Symfony\Component\HttpFoundation\JsonResponse;

class SendRequestToUserTest extends GroupTestBase
{
    public function testSendRequestToUser(): void
    {
        $payload = ['email' => 'brian@api.com'];

        self::$julia->request(
            'PUT',
             sprintf('%s/%s/send_request', $this->endpoint, $this->getJuliaGroupId()),
             [],
             [],
             [],
             json_encode($payload)
        );

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('The request has been sent!', $responseData['message']);
    }

    public function testSendAnotherGroupRequestToUser():void
    {
        $payload = ['email' => 'roger@api.com'];

        self::$brian->request(
            'PUT',
            sprintf('%s/%s/send_request', $this->endpoint, $this->getJuliaGroupId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You are not the owner of this group', $responseData['message']);
    }

    public function testSendRequestToAlreadyMember(): void
    {
        $payload = ['email' => 'julia@api.com'];

        self::$julia->request(
            'PUT',
            sprintf('%s/%s/send_request', $this->endpoint, $this->getJuliaGroupId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
        $this->assertEquals('This user is already member of the group', $responseData['message']);
    }

}