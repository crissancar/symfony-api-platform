<?php


namespace App\Tests\Functional\Category;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateCategoryTest extends CategoryTestBase
{
    public function testCreateCategory(): void
    {
        $payload = [
            'name' => 'new category',
            'type' => Category::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getJuliaId()),
        ];

        self::$julia->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
        $this->assertEquals($payload['type'], $responseData['type']);
        $this->assertEquals($payload['owner'], $responseData['owner']);
    }

    public function testCreateCategoryForAnotherUser(): void
    {
        $payload = [
            'name' => 'new category',
            'type' => Category::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getBrianId()),
        ];

        self::$julia->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testCreateCategoryForGroup(): void
    {
        $payload = [
            'name' => 'new category',
            'type' => Category::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getJuliaId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getJuliaGroupId()),
        ];

        self::$julia->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
        $this->assertEquals($payload['type'], $responseData['type']);
        $this->assertEquals($payload['owner'], $responseData['owner']);
        $this->assertEquals($payload['group'], $responseData['group']);
    }

    public function testCreateCategoryForAnotherGroup(): void
    {
        $payload = [
            'name' => 'new category',
            'type' => Category::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getJuliaId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getBrianGroupId()),
        ];

        self::$julia->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testCreateCategoryWithUnsupportedType(): void
    {
        $payload = [
            'name' => 'new category',
            'type' => 'invalid-type',
            'owner' => \sprintf('/api/v1/users/%s', $this->getJuliaId()),
        ];

        self::$julia->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$julia->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}