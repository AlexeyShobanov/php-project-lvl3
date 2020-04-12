<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;

class WelcomeControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }
}
