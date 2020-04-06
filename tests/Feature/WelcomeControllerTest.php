<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain;
//use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class WelcomeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        factory(Domain::class, 2)->make();
    }

    protected function prepareTestData () {
        $factoryData = factory(Domain::class)->make()->toArray();
        $url = \Arr::only($factoryData, ['name']);
        $parsedUrl = parse_url($url['name']);
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : 'https://';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $normalizedUrl = $scheme . $host;
        return $normalizedUrl;
        /*
        return Http::fake([
            $normalizedUrl => Http::response('Hello World', 200, ['Headers']),
        ]);
        */
    }

    public function testIndex()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $url = $this->prepareTestData();
        $response = $this->post(route('store'), ['name' => $url]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('domains', ['name' => $url]);
    }
}
