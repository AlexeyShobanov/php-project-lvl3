<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain;

class DomainCheckControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        factory(Domain::class, 2)->make();
    }

    public function testStore()
    {
        $factoryData = factory(Domain::class)->make()->toArray();
        $url = \Arr::only($factoryData, ['name']);
        $parsedUrl = parse_url($url['name']);
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : 'https://';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $normalizedUrl = $scheme . $host;
        $response = $this->post(route('store'), ['name' => $normalizedUrl]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('domains', ['name' => $normalizedUrl]);
        $domain = \DB::table('domains')->where('name', $normalizedUrl)->first();
        $response = $this->post(route('domains.checks.store', $domain->id));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('domain_checks', ['domain_id' => $domain->id]);
    }
}
