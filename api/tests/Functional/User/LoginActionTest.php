<?php


namespace App\Tests\Functional\User;


use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginActionTest extends UserTestBase
{
    public function testLogin(): void
    {
        $payload = [
            'username' => 'julia@api.com',
            'password' => 'password',
        ];

        self::$julia->request('POST', \sprintf('%s/login_check', $this->endpoint), [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationSuccessResponse::class, $response);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $payload = [
            'username' => 'julia@api.com',
            'password' => 'invalid-password',
        ];

        self::$julia->request('POST', \sprintf('%s/login_check', $this->endpoint), [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationFailureResponse::class, $response);
    }
}