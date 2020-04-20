<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;

class DomainControllerTest extends TestCase
{
    private const DOMAIN_RU = ['name' => 'https://ru.hexlet.io'];
    private const DOMAIN_EN = ['name' => 'https://en.hexlet.io'];
    private $id;

    protected function setUp(): void
    {
        parent::setUp();
        $this->domain = factory(Domain::class)->create(self::DOMAIN_EN);
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->post(route('domains.store'), ['name' => self::DOMAIN_RU['name']]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('domains', self::DOMAIN_RU);
    }

    public function testShow()
    {
        $response = $this->get(route('domains.show', ['domain' => $this->domain]));
        $response->assertStatus(200);
    }
}
