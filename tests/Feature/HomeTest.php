<?php

declare(strict_types=1);

namespace Test\Feature;

class HomeTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $response = $this->get('/');

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($content = $response->getBody()->getContents());

        $data = json_decode($content, true);

        self::assertEquals(['name' => 'Api'], $data);
    }
}
