<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;

class WelcomeTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
