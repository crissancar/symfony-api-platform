<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\JsonResponse;

class ResetPasswordActionTest extends UserTestBase
{
    public function testResetPassword(): void
    {
        $juliaId = $this->getJuliaId();
        $payload = [
            'resetPasswordToken' => '123456',
            'password' => 'new-password',
        ];

        self::$julia->request('PUT', sprintf('%s/%s/reset_password', $this->endpoint, $juliaId), [], [], [], json_encode($payload));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaId, $responseData['id']);
    }
}