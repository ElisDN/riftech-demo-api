<?php

declare(strict_types=1);

namespace Test\Feature\Profile;

use Test\Feature\AuthFixture;
use Test\Feature\WebTestCase;

class ShowTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->loadFixtures([
            'auth' => AuthFixture::class,
        ]);

        parent::setUp();
    }

    public function testGuest(): void
    {
        $response = $this->get('/profile');
        self::assertEquals(401, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $fixture = $this->getAuth();

        $response = $this->get('/profile', $fixture->getHeaders());

        self::assertEquals(200, $response->getStatusCode());

        self::assertJson($content = $response->getBody()->getContents());

        $data = json_decode($content, true);

        self::assertEquals([
            'id' => $fixture->getUser()->getId()->getId(),
        ], $data);
    }

    private function getAuth(): AuthFixture
    {
        return $this->getFixture('auth');
    }
}
