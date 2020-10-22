<?php


namespace App\Tests\Functional\Movement;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadFileTest extends MovementTestBase
{
    public function testUploadedFile(): void
    {
        $file = new UploadedFile(
            __DIR__.'/../../../fixtures/ticket.jpg',
            'ticket.jpg'
        );

        self::$julia->request(
            'POST',
            sprintf('%s/%s/upload_file', $this->endpoint, $this->getJuliaMovementId()),
            [],
            ['file' => $file]
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUploadedFileWithWrongInputName(): void
    {
        $file = new UploadedFile(
            __DIR__.'/../../../fixtures/ticket.jpg',
            'ticket.jpg'
        );

        self::$julia->request(
            'POST',
            sprintf('%s/%s/upload_file', $this->endpoint, $this->getJuliaMovementId()),
            [],
            ['non-valid-input' => $file]
        );

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}