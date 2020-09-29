<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\JsonResponse;

class ResendActivationEmailActionTest extends UserTestBase
{
    public function testResendActivationEmail(): void
    {
        $payload = ['email' => 'roger@api.com'];

        self::$roger->request('POST', sprintf('%s/resend_activation_email', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$roger->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testResendActivationEmailToActiveUser(): void
    {
        $payload = ['email' => 'julia@api.com'];

        self::$julia->request('POST', sprintf('%s/resend_activation_email', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
    }
}