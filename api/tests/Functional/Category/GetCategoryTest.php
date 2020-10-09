<?php


namespace App\Tests\Functional\Category;


use Symfony\Component\HttpFoundation\JsonResponse;

class GetCategoryTest extends CategoryTestBase
{
    public function testGetCategory(): void
    {
        $juliaExpenseCategoryId = $this->getJuliaExpenseCategoryId();

        self::$julia->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaExpenseCategoryId));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaExpenseCategoryId, $responseData['id']);
    }

    public function testGetGroupCategory(): void
    {
        $juliaGroupExpenseCategoryId = $this->getJuliaGroupExpenseCategoryId();

        self::$julia->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaGroupExpenseCategoryId));

        $response = self::$julia->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($juliaGroupExpenseCategoryId, $responseData['id']);
    }

    public function testGetAnotherUserCategory(): void
    {
        $juliaExpenseCategoryId = $this->getJuliaExpenseCategoryId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaExpenseCategoryId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testGetAnotherGroupCategory(): void
    {
        $juliaGroupExpenseCategoryId = $this->getJuliaGroupExpenseCategoryId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $juliaGroupExpenseCategoryId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}