<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;
use Illuminate\Support\Facades\Http;

class DomainCheckControllerTest extends TestCase
{
    private $domain;
    private const DOMAIN = ['name' => 'https://ru.hexlet.io'];
    private $params = [
        'status_code' => 200,
        'h1' => "This is H1",
        'keywords' => "There are Keywords",
        'description' => "This is Description",
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->domain = factory(Domain::class)->create(self::DOMAIN);
    }

    public function testStore()
    {
        $partsOfPath = [__DIR__, '..', 'fixtures', 'test.html'];
        $modifyPath = implode(DIRECTORY_SEPARATOR, $partsOfPath);
        $html = file_get_contents($modifyPath);

        Http::fake(
            [
                $this->domain->name => Http::response($html, 200, ['Headers']),
            ]
        );

        $paramsForCheck = array_merge($this->params, ['domain_id' => $this->domain->id]);

        $response = $this->post(route('domains.checks.store', $this->domain->id));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('domain_checks', $paramsForCheck);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
