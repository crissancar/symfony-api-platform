<?php


namespace App\Tests\Functional\User;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadAvatarTest extends UserTestBase
{
    public function testUploadAvatar(): void
    {
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/avatar.jpg',
            'avatar.jpg'
        );

        self::$julia->request(
            'POST',
            sprintf('%s/%s/avatar', $this->endpoint, $this->getJuliaId()),
            [],
            ['avatar' => $avatar]
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUploadAvatarWithWrongInputName(): void
    {
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/avatar.jpg',
            'avatar.jpg'
        );

        self::$julia->request(
            'POST',
            sprintf('%s/%s/avatar', $this->endpoint, $this->getJuliaId()),
            [],
            ['non-valid-input' => $avatar]
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}