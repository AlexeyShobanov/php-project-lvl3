<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain;

class DomainControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        factory(Domain::class, 2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $factoryData = factory(Domain::class)->make()->toArray();
        $url = \Arr::only($factoryData, ['name']);
        $parsedUrl = parse_url($url['name']);
        $normalizedUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'];
        $response = $this->post(route('store'), ['name' => $normalizedUrl]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $domain = \DB::table('domains')->where('name', $normalizedUrl)->value('id');
        $response = $this->get(route('domains.show', ['domain' => $domain]));
        $response->assertStatus(200);
    }
}
