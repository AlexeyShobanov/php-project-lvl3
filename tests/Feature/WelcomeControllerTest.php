<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;

class WelcomeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        factory(Domain::class, 2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }
}
