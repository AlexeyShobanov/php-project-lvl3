<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain;
use Illuminate\Support\Facades\Http;

class DomainCheckControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        factory(Domain::class, 2)->make();
    }

    protected $params = [
        'status_code' => 200,
        'h1' => "This is H1",
        'keywords' => "There are Keywords",
        'description' => "This is Description",
    ];

    public function testStore()
    {
        $factoryData = factory(Domain::class)->make()->toArray();
        $url = \Arr::only($factoryData, ['name']);
        $parsedUrl = parse_url($url['name']);
        $normalizedUrl = $parsedUrl['scheme'] . "://" . $parsedUrl['host'];

        $body = "<body>
            <h1>{$this->params['h1']}</h1>
            <meta name='keywords'  content=\"{$this->params['keywords']}\">
            <meta name='description'  content=\"{$this->params['description']}\">
        </body>";

        $response = $this->post(route('store'), ['name' => $normalizedUrl]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('domains', ['name' => $normalizedUrl]);
        $domain = \DB::table('domains')->where('name', $normalizedUrl)->first();

        Http::fake([
            $normalizedUrl => Http::response($body, 200, ['Headers']),
        ]);

        $paramsForCheck = array_merge($this->params, ['domain_id' => $domain->id]);

        $response = $this->post(route('domains.checks.store', $domain->id));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('domain_checks', $paramsForCheck);
    }
}
