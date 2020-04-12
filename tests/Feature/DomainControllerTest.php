<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DomainControllerTest extends TestCase
{
    private const DOMAIN = ['name' => 'https://ru.hexlet.io'];

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->post(route('domains.store'), ['name' => self::DOMAIN['name']]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('domains', self::DOMAIN);
    }

    public function testShow()
    {
        $domain = factory(Domain::class)->create(['name' => self::DOMAIN['name']]);
        $response = $this->get(route('domains.show', ['domain' => $domain->id]));
        $response->assertStatus(200);
    }
}
